<style lang="scss">
.actionButton {
    button {
        padding: 10px 15px;
        background-color: antiquewhite;
        cursor: pointer;
        margin-right: 10px;
        border-radius: 10px;
    }
}

input {
    width: 80%;
    height: 50px;
    border: 1px solid #e7e7e7;
    border-radius: 10px;
    padding: 5px 15px;
}

button {
    padding: 13px 15px;
    background-color: antiquewhite;
    cursor: pointer;
    margin-left: 10px;
    margin-bottom: 10px;
    border-radius: 10px;
}

table,
tr {
    border: 1px solid #e7e7e7;
}

td {
    padding: 6px;
}

.loading {
    text-align: center;
    margin: 20px;
}
</style>

<template>
    <div>
        <h2>Post Manager (DummyJSON)</h2>

        <!-- Create -->
        <div class="createData">
            <input v-model="form.title" placeholder="Enter title" />
            <button @click="createPost">Add Post</button>
        </div>

        <!-- Edit -->
        <div class="editInput actionButton" v-if="editMode">
            <h3>Edit Post</h3>
            <input v-model="editForm.title" />
            <button @click="updatePost">Update</button>
            <button @click="cancelEdit">Cancel</button>
        </div>

        <!-- Loading -->
        <div v-if="loading" class="loading">Loading...</div>

        <!-- Table -->
        <table v-else border="1" width="100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <tr v-for="post in posts" :key="post.id">
                    <td>{{ post.id }}</td>
                    <td>{{ post.title }}</td>
                    <td class="actionButton">
                        <button @click="startEdit(post)">Edit</button>
                        <button @click="remove(post.id)">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import api from "../services/api";
import { ref, onMounted } from "vue";

const posts = ref([]);
const form = ref({ title: "" });

const editMode = ref(false);
const editForm = ref({ id: null, title: "" });

const loading = ref(false);

// 🔥 Fetch
const fetchPosts = async () => {
    try {
        loading.value = true;
        const res = await api.getPosts();
        posts.value = res.data.posts;
    } catch (err) {
        console.error("Fetch Error:", err);
    } finally {
        loading.value = false;
    }
};

// ➕ Create (Optimized)
const createPost = async () => {
    if (!form.value.title) return;

    try {
        const res = await api.createPost(form.value);

        // 🔥 UI instant update
        posts.value.unshift({
            id: Date.now(), // fake id
            title: form.value.title,
        });

        form.value.title = "";
    } catch (err) {
        console.error("Create Error:", err);
    }
};

// ❌ Delete (Optimized)
const remove = async (id) => {
    try {
        await api.deletePost(id);

        // 🔥 local remove (no reload)
        posts.value = posts.value.filter((p) => p.id !== id);
    } catch (err) {
        console.error("Delete Error:", err);
    }
};

// ✏️ Start Edit
const startEdit = (post) => {
    editMode.value = true;
    editForm.value = { ...post };
};

// 🔄 Update (Optimized)
const updatePost = async () => {
    try {
        await api.updatePost(editForm.value.id, editForm.value);

        // 🔥 update locally
        const index = posts.value.findIndex(
            (p) => p.id === editForm.value.id
        );

        if (index !== -1) {
            posts.value[index].title = editForm.value.title;
        }

        editMode.value = false;
    } catch (err) {
        console.error("Update Error:", err);
    }
};

const cancelEdit = () => {
    editMode.value = false;
};

onMounted(fetchPosts);
</script>
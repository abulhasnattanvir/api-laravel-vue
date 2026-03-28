<template>
    <div>
        <h2>Login</h2>

        <input v-model="form.username" placeholder="Username" />
        <input v-model="form.password" type="password" placeholder="Password" />

        <button @click="login">Login</button>
    </div>
</template>

<script setup>
import { ref } from "vue";
import api from "../services/api";

const form = ref({
    username: "kminchelle",
    password: "0lelplR",
});

const login = async () => {
    const res = await api.login(form.value);

    // 🔥 save token
    localStorage.setItem("token", res.data.token);

    alert("Login Success");
};
</script>
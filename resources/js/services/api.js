import axios from "axios";

export default {
    getPosts: () => axios.get('/posts'),
    createPost: (data) => axios.post('/posts', data),
    updatePost: (id, data) => axios.put(`/posts/${id}`, data),
    deletePost: (id) => axios.delete(`/posts/${id}`),
};
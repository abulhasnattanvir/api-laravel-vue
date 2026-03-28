import axios from "axios";

const instance = axios.create();

instance.interceptors.request.use((config) => {
    const token = localStorage.getItem("token");

    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }

    return config;
});

export default {
    getPosts: () => instance.get('/posts'),
    createPost: (data) => instance.post('/posts', data),
    updatePost: (id, data) => instance.put(`/posts/${id}`, data),
    deletePost: (id) => instance.delete(`/posts/${id}`),
    login: (data) => instance.post('/login', data),
};
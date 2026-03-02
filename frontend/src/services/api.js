import axios from 'axios';

// Configuração base do Axios
const api = axios.create({
    baseURL: '/',
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
    },
    withCredentials: true,
});

// Interceptor para adicionar CSRF token
api.interceptors.request.use((config) => {
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (token) {
        config.headers['X-CSRF-TOKEN'] = token;
    }
    return config;
});

// Funções de API
export const produtoAPI = {
    buscar: (params) => {
        return api.get('/produtos/buscar', { params });
    },
    detalhes: (id) => {
        return api.get(`/produtos/${id}/detalhes`);
    },
};

export const usuarioAPI = {
    dashboard: (params) => {
        return api.get('/', { params });
    },
    logout: () => {
        return api.post('/logout');
    },
    perfil: () => {
        return api.get('/usuarios/perfil');
    },
};

export const carrinhoAPI = {
    ver: () => {
        return api.get('/carrinho');
    },
    adicionar: (produtoId, data) => {
        return api.post(`/carrinho/adicionar/${produtoId}`, data);
    },
    remover: (produtoId, tamanho) => {
        return api.delete(`/carrinho/remover/${produtoId}/${tamanho}`);
    },
};

export const listaDesejoAPI = {
    index: () => {
        return api.get('/lista-desejos');
    },
    store: (produtoId) => {
        return api.post(`/lista-desejos/${produtoId}`);
    },
    destroy: (produtoId) => {
        return api.delete(`/lista-desejos/${produtoId}`);
    },
};

export default api;


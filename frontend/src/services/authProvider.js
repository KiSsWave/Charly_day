import { jwtDecode } from 'jwt-decode';

const isAuthenticated = () => {
    const token = localStorage.getItem("token");
    return !!token;
};

const removeToken = () => {
    localStorage.removeItem("token");
};

const setToken = (token) => {
    localStorage.setItem("token", token);
};

const setRole = (role) => {
    localStorage.setItem("role", role);
};

const getRole = () => {
    return localStorage.getItem("role");
};

const getUserIdentity = () => {
    const token = localStorage.getItem("token");
    return token ? jwtDecode(token) : null;
};

export { isAuthenticated, removeToken, setToken, setRole, getRole, getUserIdentity };

import axios from "axios";

const apiClient = axios.create({
  baseURL: "http://localhost:49050",
  headers: {
    "Content-Type": "application/json",
    Authorization: `Bearer ${localStorage.getItem("token")}`,
  },
});

export default apiClient;

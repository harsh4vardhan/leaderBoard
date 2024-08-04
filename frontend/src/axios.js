// src/axios.js
import axios from 'axios';

const instance = axios.create({
  baseURL: import.meta.env.VITE_API_URL || 'http://localhost:8000', // Default to localhost for development
});

export default instance;
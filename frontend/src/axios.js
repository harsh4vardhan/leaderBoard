// src/axios.js
import axios from 'axios';

const instance = axios.create({
  baseURL: import.meta.env.VITE_API_URL || 'http://89.116.159.2/', // Default to localhost for development
});

export default instance;
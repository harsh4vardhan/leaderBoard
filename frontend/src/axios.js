// src/axios.js
import axios from 'axios';

const instance = axios.create({
  baseURL: '', // Default to localhost for development
});

export default instance;
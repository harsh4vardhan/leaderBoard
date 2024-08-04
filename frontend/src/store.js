// src/store.js
import { defineStore } from 'pinia';
import axios from './axios';

export const useLeaderboardStore = defineStore('leaderboard', {
  state: () => ({
    users: [],
    userDetails: null,
  }),
  actions: {
    async fetchUsers(page = 1, limit = 10) {
      try {
        const response = await axios.get('/api/leaderboard-users', { params: { page, limit } });
        this.users = response.data;
      } catch (error) {
        console.error('Error fetching users:', error);
      }
    },
    async addUser(user) {
      try {
        await axios.post('/api/leaderboard-users', user);
        this.fetchUsers(); // Refresh the user list after adding a new user
      } catch (error) {
        console.error('Error adding user:', error);
      }
    },
    async deleteUser(userId) {
      try {
        await axios.delete(`/api/leaderboard-users/${userId}`);
        this.fetchUsers(); // Refresh the user list after deletion
      } catch (error) {
        console.error('Error deleting user:', error);
      }
    },
    async fetchUserDetails(userId) {
      try {
        const response = await axios.get(`/api/leaderboard-users/${userId}`);
        this.userDetails = response.data;
      } catch (error) {
        console.error('Error fetching user details:', error);
      }
    },
    async searchUsers(query) {
      try {
        const response = await axios.get(`/api/leaderboard-users/search`, { params: { q: query } });
        this.users = response.data;
      } catch (error) {
        console.error('Error searching users:', error);
      }
    },
    async sortUsersByName() {
      try {
        const response = await axios.get('/api/leaderboard-users/sort/name');
        this.users = response.data;
      } catch (error) {
        console.error('Error sorting by name:', error);
      }
    },
    async sortUsersByPoints() {
      try {
        const response = await axios.get('/api/leaderboard-users/sort/points');
        this.users = response.data;
      } catch (error) {
        console.error('Error sorting by points:', error);
      }
    },
    async groupByScore() {
      try {
        const response = await axios.get('/api/leaderboard-users/group/score');
        console.log('Grouped by score:', response.data);
      } catch (error) {
        console.error('Error grouping by score:', error);
      }
    },
    async updateUserScore(userId, scoreChange) {
      try {
        await axios.put(`/api/leaderboard-users/${userId}`, { points: scoreChange });
        this.fetchUsers(); // Refresh the user list after updating score
      } catch (error) {
        console.error('Error updating user score:', error);
      }
    }
  }
});

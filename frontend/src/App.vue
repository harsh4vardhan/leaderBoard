<!-- src/App.vue -->
<template>
  <div>
    <h1 class="text-3xl font-bold text-center">LeaderBoard App</h1>
    <leaderboard :users="users" @viewDetails="fetchUserDetails" @addUser="addUser" @deleteUser="deleteUser" />
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useLeaderboardStore } from './store';
import Leaderboard from './components/Leaderboard.vue';
import UserDetails from './components/UserDetails.vue';

const store = useLeaderboardStore();

const users = store.users;
const userDetails = store.userDetails;
const searchQuery = ref('');

const searchUsers = () => {
  store.searchUsers(searchQuery.value);
};

const sortByName = () => {
  store.sortByName();
};

const sortByPoints = () => {
  store.sortByPoints();
};

const fetchUserDetails = (userId) => {
  store.fetchUserDetails(userId);
};

const addUser = (user) => {
  store.addUser(user);
};

const deleteUser = (userId) => {
  store.deleteUser(userId);
};

store.fetchUsers(); // Initial fetch
</script>

<template>
    <div class="flex items-center p-4 bg-gray-100 border-b border-gray-200">
      <!-- Sort Buttons with Icons -->
      <div class="flex space-x-2">
        <button
          @click="sortByName"
          class="flex items-center bg-gray-500 text-white px-2 py-1 rounded-md hover:bg-gray-600"
        >
          <i class="fas fa-sort-alpha-up mr-2"></i>
          Name
        </button>
        <button
          @click="sortByPoints"
          class="flex items-center bg-gray-500 text-white px-2 py-1 rounded-md hover:bg-gray-600"
        >
          <i class="fas fa-sort-numeric-up mr-2"></i>
          Points
        </button>
      </div>
  
      <!-- Search Input -->
      <input
        v-model="searchQuery"
        type="text"
        placeholder="Search users..."
        class="mx-4 p-2 border rounded-md flex-grow"
      />
  
      <!-- Add User Button -->
      <button
        @click="toggleAddUserForm"
        class="ml-auto bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600"
      >
        Add User
      </button>
  
      <!-- Winner Display -->
      <div class="ml-4 flex items-center">
        <span v-if="winner" class="font-semibold">Current Winner:</span>
        <span v-if="winner" class="ml-2">
          {{ winner.name }} ({{ winner.points }} points)
        </span>
        <span v-else class="ml-2">Winner: TBD</span>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted, watch } from 'vue';
  
  const props = defineProps(['searchQuery', 'showAddUserForm']);
  const emit = defineEmits(['update:searchQuery', 'update:showAddUserForm', 'sortByName', 'sortByPoints']);
  
  const searchQuery = ref(props.searchQuery);
  const winner = ref(null);
  
  const toggleAddUserForm = () => {
    emit('update:showAddUserForm', !props.showAddUserForm);
  };
  
  const sortByName = () => {
    emit('sortByName');
  };
  
  const sortByPoints = () => {
    emit('sortByPoints');
  };
  
  const fetchWinner = async () => {
    try {
      const response = await fetch('/api/leaderboard-winner');
      if (response.ok) {
        winner.value = await response.json();
      } else {
        winner.value = null;
      }
    } catch (error) {
      console.error('Error fetching winner:', error);
      winner.value = null;
    }
  };
  
  // Fetch the winner when the component is mounted and set interval to refresh every 6 minutes
  onMounted(() => {
    fetchWinner(); // Initial fetch
    const interval = setInterval(fetchWinner, 360000); // 360000 ms = 6 minutes
  
    // Clean up interval on component unmount
    return () => clearInterval(interval);
  });
  
  // Watch for changes in searchQuery and emit them to the parent component
  watch(searchQuery, (newValue) => {
    emit('update:searchQuery', newValue);
  });
  </script>
  
  <style scoped>
  /* Add any custom styles here */
  </style>
  
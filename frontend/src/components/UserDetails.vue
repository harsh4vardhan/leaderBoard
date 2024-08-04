<template>
    <div class="p-4 max-w-4xl mx-auto">
      <!-- Header -->
      <header class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Leaderboard</h1>
        <div>
          <input 
            v-model="searchQuery" 
            type="text" 
            placeholder="Search by name..." 
            class="p-2 border rounded-md"
          />
          <button 
            @click="showAddUserForm = true" 
            class="ml-4 bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600"
          >
            Add User
          </button>
        </div>
      </header>
  
      <!-- Add User Form -->
      <div v-if="showAddUserForm" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50">
        <div class="bg-white p-6 rounded-md shadow-lg w-full max-w-md">
          <h2 class="text-xl font-bold mb-4">Add New User</h2>
          <form @submit.prevent="handleAddUser">
            <div class="mb-4">
              <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
              <input 
                v-model="newUser.name" 
                type="text" 
                id="name" 
                required 
                class="mt-1 p-2 border rounded-md w-full"
              />
            </div>
            <div class="mb-4">
              <label for="age" class="block text-sm font-medium text-gray-700">Age</label>
              <input 
                v-model="newUser.age" 
                type="number" 
                id="age" 
                required 
                class="mt-1 p-2 border rounded-md w-full"
              />
            </div>
            <div class="mb-4">
              <label for="points" class="block text-sm font-medium text-gray-700">Points</label>
              <input 
                v-model="newUser.points" 
                type="number" 
                id="points" 
                required 
                class="mt-1 p-2 border rounded-md w-full"
              />
            </div>
            <div class="mb-4">
              <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
              <input 
                v-model="newUser.address" 
                type="text" 
                id="address" 
                required 
                class="mt-1 p-2 border rounded-md w-full"
              />
            </div>
            <div class="flex justify-end">
              <button 
                type="button" 
                @click="showAddUserForm = false" 
                class="mr-4 bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600"
              >
                Cancel
              </button>
              <button 
                type="submit" 
                class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600"
              >
                Add User
              </button>
            </div>
          </form>
        </div>
      </div>
  
      <!-- User List -->
      <ul class="list-none p-0">
        <li v-for="user in filteredUsers" :key="user.id" 
            class="relative mb-2 border rounded-md bg-white shadow-sm overflow-hidden transition-all duration-300"
            :class="{ 'expanded': activeUserId === user.id, 'collapsed': activeUserId !== user.id }">
          <button 
            @click="deleteUser(user.id)" 
            class="absolute top-2 left-2 bg-red-500 text-white px-2 py-1 rounded-md hover:bg-red-600"
          >
            x
          </button>
          <div class="flex items-center justify-between p-4">
            <div class="flex-1">
              <span 
                @click="toggleDetails(user.id)" 
                class="text-lg font-semibold cursor-pointer hover:underline"
              >
                {{ user.name }}
              </span>
              <span class="ml-4 text-gray-600">{{ user.points }} Points</span>
            </div>
            <div>
              <button 
                @click="increaseScore(user.id)" 
                class="bg-green-500 text-white px-3 py-1 rounded-md hover:bg-green-600"
              >
                +
              </button>
              <button 
                @click="decreaseScore(user.id)" 
                class="bg-yellow-500 text-white px-3 py-1 rounded-md hover:bg-yellow-600 ml-2"
              >
                -
              </button>
            </div>
          </div>
          
          <!-- Expanded User Details -->
          <UserDetails v-if="activeUserId === user.id" :details="user" class="transition-max-height duration-300 ease-in-out" />
        </li>
      </ul>
    </div>
  </template>
  
  <script setup>
  import { ref, computed } from 'vue';
  import { useLeaderboardStore } from '../store';
  import UserDetails from './UserDetails.vue'; // Import the UserDetails component
  
  // Use Pinia store
  const store = useLeaderboardStore();
  
  // Reactive state for search query
  const searchQuery = ref('');
  
  // Filtered list of users based on search query
  const filteredUsers = computed(() => {
    return store.users.filter(user => 
      user.name.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
  });
  
  // Reactive state for showing the add user form
  const showAddUserForm = ref(false);
  const newUser = ref({
    name: '',
    age: '',
    points: '',
    address: ''
  });
  
  // State for active user details
  const activeUserId = ref(null);
  
  // Fetch initial list of users
  store.fetchUsers();
  
  const deleteUser = async (userId) => {
    await store.deleteUser(userId);
    await store.fetchUsers(); // Refresh the user list after deletion
  };
  
  const handleAddUser = async () => {
    if (newUser.value.name && newUser.value.age && newUser.value.points && newUser.value.address) {
      await store.addUser({ ...newUser.value });
      await store.fetchUsers(); // Refresh the user list after adding a new user
      showAddUserForm.value = false; // Close the form
      newUser.value = { name: '', age: '', points: '', address: '' }; // Reset form fields
    }
  };
  
  const increaseScore = async (userId) => {
    await store.updateUserScore(userId, 1); // Increment score by 1
    await store.fetchUsers(); // Refresh the user list
  };
  
  const decreaseScore = async (userId) => {
    await store.updateUserScore(userId, -1); // Decrement score by 1
    await store.fetchUsers(); // Refresh the user list
  };
  
  const toggleDetails = (userId) => {
    activeUserId.value = activeUserId.value === userId ? null : userId;
  };
  </script>
  
  <style scoped>
  /* Sliding animation */
  .expanded {
    max-height: 400px; /* Adjust this to fit the expanded content */
  }
  
  .collapsed {
    max-height: 80px; /* Adjust this to fit the collapsed content */
  }
  
  .transition-all {
    transition: max-height 0.3s ease-in-out;
  }
  
  .relative {
    position: relative;
  }
  
  .overflow-hidden {
    overflow: hidden;
  }
  </style>
  
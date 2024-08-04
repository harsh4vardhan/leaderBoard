<template>
  <div class="p-4 max-w-4xl mx-auto">
    <!-- Topbar Component -->
    <Topbar 
      :searchQuery="searchQuery" 
      :showAddUserForm="showAddUserForm"
      @update:searchQuery="searchQuery = $event"
      @update:showAddUserForm="showAddUserForm = $event"
      @sortByName="sortByName"
      @sortByPoints="sortByPoints"
    />
  
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
              pattern="[A-Za-z\s]*" 
              title="Only letters and spaces are allowed"
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
      <li v-for="user in paginatedUsers" :key="user.id" 
          class="relative flex flex-col mb-2 p-4 border rounded-md bg-white shadow-sm transition-all duration-300"
          :class="{ 'h-60': activeUserId === user.id, 'h-20': activeUserId !== user.id }">
        <button 
          @click="deleteUser(user.id)" 
          class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-red-500 text-white px-2 py-1 rounded-md hover:bg-red-600"
        >
          x
        </button>
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
            class="bg-gray-200 text-black px-3 py-1 rounded-md hover:bg-gray-600"
          >
            +
          </button>
          <button 
            @click="decreaseScore(user.id)" 
            class="bg-gray-200 text-black px-3 py-1 rounded-md hover:bg-gray-600 ml-2"
            :disabled="user.points <= 0"
          >
            -
          </button>
        </div>
        
        <!-- Expanded User Details -->
        <div v-if="activeUserId === user.id" class="mt-2">
          <p><strong>Name:</strong> {{ user.name }}</p>
          <p><strong>Age:</strong> {{ user.age }}</p>
          <p><strong>Points:</strong> {{ user.points }}</p>
          <p><strong>Address:</strong> {{ user.address }}</p>
        </div>
      </li>
    </ul>

    <!-- Pagination Controls -->
    <div class="flex justify-center mt-4">
      <button 
        @click="changePage(currentPage - 1)" 
        :disabled="currentPage === 1"
        class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600"
      >
        Previous
      </button>
      <span class="mx-4 text-lg">{{ currentPage }} / {{ totalPages }}</span>
      <button 
        @click="changePage(currentPage + 1)" 
        :disabled="currentPage === totalPages"
        class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600"
      >
        Next
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watchEffect } from 'vue';
import { useLeaderboardStore } from '../store';
import Topbar from '../components/Topbar.vue'; // Import Topbar component

// Use Pinia store
const store = useLeaderboardStore();

// Reactive state for search query
const searchQuery = ref('');

// Pagination state
const currentPage = ref(1);
const itemsPerPage = 10; // Adjust the number of items per page as needed
const totalPages = computed(() => Math.ceil(store.users.length / itemsPerPage));

// Filtered list of users based on search query
const filteredUsers = computed(() => {
  return store.users.filter(user => 
    user.name.toLowerCase().includes(searchQuery.value.toLowerCase())
  );
});

// Paginated users based on current page and items per page
const paginatedUsers = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage;
  const end = start + itemsPerPage;
  return filteredUsers.value.slice(start, end);
});

// Reactive state for showing the add user form
const showAddUserForm = ref(false);
const newUser = ref({
  name: '',
  age: '',
  address: ''
});

// State for active user details
const activeUserId = ref(null);

// Fetch initial list of users
store.fetchUsers();

// Watch for changes in search query to update user list
watchEffect(() => {
  store.searchUsers(searchQuery.value);
});

// Handle adding a new user
const handleAddUser = async () => {
  if (newUser.value.name && newUser.value.age && newUser.value.address) {
    await store.addUser({ ...newUser.value });
    await store.fetchUsers(); // Refresh the user list after adding a new user
    showAddUserForm.value = false; // Close the form
    newUser.value = { name: '', age: '', address: '' }; // Reset form fields
  }
};

// Handle user deletion
const deleteUser = async (userId) => {
  await store.deleteUser(userId);
  await store.fetchUsers(); // Refresh the user list after deletion
};

// Increase user score
const increaseScore = async (userId) => {
  await store.updateUserScore(userId, 1); // Increment score by 1
  await store.fetchUsers(); // Refresh the user list
};

// Decrease user score
const decreaseScore = async (userId) => {
  const user = store.users.find(user => user.id === userId);
  if (user && user.points > 0) {
    await store.updateUserScore(userId, -1); // Decrement score by 1
    await store.fetchUsers(); // Refresh the user list
  }
};

// Toggle details for user
const toggleDetails = (userId) => {
  activeUserId.value = activeUserId.value === userId ? null : userId;
};

// Sort by name
const sortByName = () => {
  store.sortUsersByName();
};

// Sort by points
const sortByPoints = () => {
  store.sortUsersByPoints();
};

// Change page
const changePage = (page) => {
  if (page >= 1 && page <= totalPages.value) {
    currentPage.value = page;
  }
};
</script>

<style scoped>
/* Add any custom styles here */
</style>

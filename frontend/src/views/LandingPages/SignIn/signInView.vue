<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import axiosInstance from '@/axios'; // Assuming axios instance is already configured

// Router instance
const router = useRouter();

// Reactive properties for form fields
const email = ref('');
const password = ref('');

// Error message
const errorMessage = ref('');

// Method to handle the login request
const login = async (event) => {
  event.preventDefault(); // Prevent form submission to handle manually

  errorMessage.value = ''; // Reset any previous error messages

  // Logging values to ensure they are being correctly captured
  console.log('Email:', email.value);
  console.log('Password:', password.value);

  try {
    // Make API request to login using axios instance
    const response = await axiosInstance.post('/login', {
      email: email.value,
      password: password.value,
    });

    // On success, store the token in localStorage
    const token = response.data.access_token;
    localStorage.setItem('auth_token', token);

    alert('Login successful!');
    router.push({ name: 'dashboard' }); // Redirect to dashboard or another page
  } catch (error) {
    // Handle error (invalid credentials or other issues)
    if (error.response?.data?.message) {
      errorMessage.value = error.response.data.message;
    } else {
      errorMessage.value = 'An unexpected error occurred.';
    }
  }
};

// Method to handle email change
const handleEmailChange = (event) => {
  email.value = event.target.value;
};

// Method to handle password change
const handlePasswordChange = (event) => {
  password.value = event.target.value;
};
</script>

<template>
  <div class="login-container">
    <h2>Login</h2>

    <!-- Login Form -->
    <form @submit="login">
      <div class="form-group">
        <label for="email">Email</label>
        <input
          type="email"
          id="email"
          placeholder="Enter your email"
          :value="email"
          @input="handleEmailChange"
          required
        />
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input
          type="password"
          id="password"
          placeholder="Enter your password"
          :value="password"
          @input="handlePasswordChange"
          required
        />
      </div>

      <!-- Show error message if there is one -->
      <div v-if="errorMessage" class="error-message">
        {{ errorMessage }}
      </div>

      <button type="submit">Login</button>
    </form>
  </div>
</template>

<style scoped>
/* Simple styles for form */
.login-container {
  max-width: 400px;
  margin: auto;
  padding: 2rem;
  border: 1px solid #ddd;
  border-radius: 8px;
}

.form-group {
  margin-bottom: 1rem;
}

input {
  width: 100%;
  padding: 0.5rem;
  margin-top: 0.2rem;
  font-size: 1rem;
}

button {
  width: 100%;
  padding: 0.5rem;
  background-color: #4caf50;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

button:hover {
  background-color: #45a049;
}

.error-message {
  color: red;
  font-size: 0.9rem;
}
</style>

import axios from 'axios';

const axiosInstance = axios.create({
  baseURL: 'http://127.0.0.1:8000/api', 
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  },
});

axiosInstance.interceptors.request.use((config) => { // interceptor pre automaticke zachytenie tokenu
  const token = localStorage.getItem('auth_token');
  if (token) {
    config.headers['Authorization'] = `Bearer ${token}`;
  }
  return config;
});

axiosInstance.interceptors.response.use(response => {
  return response;
}, error => {
  // session expired or is invalid
  if (error.response && error.response.status === 401) {
      const message = error.response.data?.message;

      if (message === 'Unauthenticated.') {
        console.log('Session expired got 401.');
        alert("Boli ste odhlásený, prihláste sa znova");
      }
      // always delete in case of 401
      localStorage.removeItem('auth_token');
      localStorage.removeItem('session');

  } 
  // Return this otherwise error messages will not show in some forms
  return Promise.reject(error);
});

export default axiosInstance;
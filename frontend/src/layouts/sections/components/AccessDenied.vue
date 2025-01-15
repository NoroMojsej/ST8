<template>
    <div class="access-denied">
      <h1>Nepovolený Prístup</h1>
      <p>Na zobrazenie tejto stránky nemáte povolenie.</p>
      <router-link to="/" class="btn btn-success">Domov</router-link>
    </div>
  </template>
  
  <script>
  export default {
    name: "AccessDenied",
  };
  </script>
  
  <style scoped>
  .access-denied {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100vh;
    text-align: center;
    background-color: #ffffff;
    color: #ff0000;
    font-family: Arial, sans-serif;
  }
  
  .access-denied h1 {
    font-size: 3rem;
    margin-bottom: 1rem;
  }
  
  .access-denied p {
    font-size: 1.25rem;
    margin-bottom: 2rem;
  }
  
  .access-denied .btn {
    display: inline-block;
    padding: 0.75rem 1.5rem;
    font-size: 1rem;
    color: #fff;
    background-color: #00b32d;
    border: none;
    border-radius: 0.25rem;
    text-decoration: none;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }
  
  .access-denied .btn:hover {
    background-color: #67d883;
  }
  </style>
  
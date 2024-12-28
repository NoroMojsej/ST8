<script setup>
import { ref, onMounted } from 'vue';
import axiosInstance from '@/axios';

import setNavPills from "@/assets/js/nav-pills.js";

import BaseLayout from "../../components/BaseLayout.vue";
import MaterialInput from "@/components/MaterialInput.vue";
import MaterialButton from "@/components/MaterialButton.vue";

onMounted(() => {
  setNavPills();
  fetchUserData();
});

//const session1 = localStorage.getItem('session'); UNDEFINED, nefunguje
const session = JSON.parse(localStorage.getItem('session'));
console.log("SES2 " + session.user_id)

const name = ref('');
const surname = ref('');
const email = ref('');
const country = ref('');

const selectedUniversity = ref('');
const selectedFaculty = ref('');
const selectedDepartment = ref('');

const countries = ref('');
const departments = ref('');
const faculties = ref('');
const universities = ref('');

const orgPswd = ref('');
const newPswd = ref('');

const successMessage1 = ref('');
const errorMessage1 = ref('');
const successMessage2 = ref('');
const errorMessage2 = ref('');

const fetchUserData = async () => {
  try {
    const response = await axiosInstance.get(`/user/${session.user_id}`);

    name.value = response.data.name;
    surname.value = response.data.surname;
    email.value = response.data.email;
    selectedUniversity.value = response.data.university.iduniversity;
    selectedFaculty.value = response.data.faculty.idfaculty;
    selectedDepartment.value = response.data.department.iddepartment;
    country.value = response.data.country.idcountry;

    await fetchCountries();
    await fetchDepartments();
    await fetchFaculties();
    await fetchUniversities();

  } catch (error) {
    console.error('Failed to fetch data:', error);
  }
};

const fetchCountries = async () => {
  try {
    const response = await axiosInstance.get('/countries');
    countries.value = response.data;
    console.log(countries.value);
  } catch (error) {
    console.error('Failed to fetch countries:', error);
  }
};

const onUniversityChange = () => {
  faculties.value = [];
  departments.value = [];
  selectedFaculty.value = null;
  selectedDepartment.value = null;
  fetchFaculties();
};

const onFacultyChange = () => {
  departments.value = [];
  selectedDepartment.value = null;
  console.log("University ID " + selectedDepartment.value);
  fetchDepartments();
};

const fetchDepartments = async () => {
  try {
    const response = await axiosInstance.get(`/departments/${selectedFaculty.value}`);
    departments.value = response.data;
  } catch (error) {
    console.error('Failed to fetch universities:', error);
  }
};

const fetchFaculties = async () => {
  try {
    const response = await axiosInstance.get(`/faculties/${selectedUniversity.value}`);
    faculties.value = response.data;
  } catch (error) {
    console.error('Failed to fetch faculties:', error);
  }
};

const fetchUniversities = async () => {
  try {
    const response = await axiosInstance.get('/universities');
    universities.value = response.data;
  } catch (error) {
    console.error('Failed to fetch countries:', error);
  }
};

async function updateUser() {
  try {
    const response = await axiosInstance.put(`/updateUser/${session.user_id}`, {
      name: name.value,
      surname: surname.value,
      email: email.value,
      country: country.value,
      university: selectedUniversity.value,
      faculty: selectedFaculty.value,
      department: selectedDepartment.value
    });

    if (response && response.data) {
      successMessage1.value = response.data.message || 'User updated successfully!';
      errorMessage1.value = '';
    }

  } catch (error) {
    errorMessage1.value = error.response?.data?.message || 'An error occurred while updating the user.';
    successMessage1.value = '';
    console.log("ERROR " + error)
  }
}

async function changePswd() {
  try {
    const response = await axiosInstance.put(`/user/changePassword/${session.user_id}`, {
      orgPswd: orgPswd.value,
      newPswd: newPswd.value,
    });

    if (response && response.data) {
      successMessage2.value = response.data.message || 'Password updated successfully!';
      errorMessage2.value = '';
    }

  } catch (error) {
    errorMessage2.value = error.response?.data?.message || 'Password change failed.';
    successMessage2.value = '';
    console.log("ERROR " + error)
  }
}

</script>

<template scoped>
  <BaseLayout title="Editácia profilu" :breadcrumb="[
    { label: 'Domov', route: '/' },
    { label: 'Editácia profilu' },
  ]">

    <div class="container">

      <div class="row">
        <div class="col-sm">
          <MaterialInput id="name" class="input-group-static mt-2 mb-4" label="MENO" type="text" v-model="name" />
        </div>
        <div class="col-sm">
          <MaterialInput id="surname" class="input-group-static mt-2 mb-4" label="PRIEZVISKO" type="text"
            v-model="surname" />
        </div>
      </div>

      <div class="row">
        <div class="col-sm">
          <MaterialInput id="email" class="input-group-static mt-2 mb-4" label="EMAIL" type="email" v-model="email" />
        </div>
        <div class="col-sm">
          <div class="input-group input-group-static mt-2 mb-4">
            <h6>KRAJINA</h6>
            <select v-model="country" class="mt-3">
              <option v-for="country in countries" :value="country.idcountry">
                {{ country.name }}
              </option>
            </select>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm mt-2">
          <div class="mt-2 mb-2">
            <h6>UNIVERZITA</h6>
            <select v-model="selectedUniversity" @change="onUniversityChange">
              <option v-for="university in universities" :key="university.iduniversity"
                :value="university.iduniversity">
                {{ university.name }}
              </option>
            </select>
          </div>
        </div>

        <div class="col-sm mt-2">
          <div class="mt-2 mb-2">
            <h6>FAKULTA</h6>
            <select id="faculty" v-model="selectedFaculty" @change="onFacultyChange">
              <option v-for="faculty in faculties" :key="faculty.idfaculty" :value="faculty.idfaculty">
                {{ faculty.name }}
              </option>
            </select>
          </div>
        </div>

        <div class="col-sm mt-2">
          <div class="mt-2 mb-2">
            <h6>KATEDRA</h6>
            <select v-model="selectedDepartment">
              <option v-for="department in departments" :value="department.iddepartment">
                {{ department.name }}
              </option>
            </select>
          </div>
        </div>

      </div>

      <div class="button-holder">
        <div v-if="errorMessage1" class="text-danger mt-2">{{ errorMessage1 }}</div>
        <div v-if="successMessage1" class="text-success mt-2">{{ successMessage1 }}</div>
        <MaterialButton variant="contained" color="success" class="w-auto me-2" size="md"
          style="font-family: 'Open Sans' !important" @click="updateUser">
          UPRAVIŤ
        </MaterialButton>
      </div>


      <div class="row pt-4">
        <h4>Zmena hesla</h4>
        <div class="col-sm">
          <MaterialInput id="orgPswd" class="input-group-static mt-2 mb-2" label="Vložte pôvodné heslo" type="password"
            v-model="orgPswd" />
        </div>
        <div class="col-sm">
          <MaterialInput id="newPswd" class="input-group-static mt-2 mb-2" label="Vložte nové heslo" type="password"
            v-model="newPswd" />
        </div>
      </div>

      <div class="button-holder">
        <div v-if="errorMessage2" class="text-danger mt-2">{{ errorMessage2 }}</div>
        <div v-if="successMessage2" class="text-success mt-2">{{ successMessage2 }}</div>
        <MaterialButton variant="contained" color="success" class="w-auto me-2" size="md"
          style="font-family: 'Open Sans' !important" @click="changePswd">
          ZMENIŤ HESLO
        </MaterialButton>
      </div>
    </div>

  </BaseLayout>
</template>

<style scoped>
.button-holder {
  width: 100%;
  padding-top: 5%;
  display: flex;
  justify-content: end;
}

h6 {
  color: #4caf50;
  font-weight: 350;
}

h4 {
  font-weight: 30px;
  font-family: 'Montserrat', sans-serif !important;
}

select {
  border: solid;
  border-width: thin !important;
  border-top: 0px;
  border-right: 0px;
  border-left: 0px;
  border-radius: 0px;
  border-color: #4caf50;
  width: 100%
}

select:focus {
  outline-color: #4caf50;
  border: none;
  box-shadow: none;
}

.text-success,
.text-danger {
  padding-right: 5px;
}
</style>
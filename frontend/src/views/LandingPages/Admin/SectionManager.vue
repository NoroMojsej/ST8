<script setup>
import { ref, computed } from "vue";
import BaseLayout from "@/layouts/sections/components/BaseLayout.vue";
import axiosInstance from '@/axios';


const sections = ref([]);

const getAllSections = async () => {
  try {
    const response = await axiosInstance.post('/sections/get-all-sections', {
      headers: {
        'Content-Type': 'application/json',
      },
    });

    console.log('Sections retrieved successfully:', response.data);


    sections.value = response.data.map(section => ({
      id: section.idsection,
      section: section.text,
      isEditing: false,
    }));
  } catch (error) {
    console.error('Sections retrieving failed:', error.response?.data || error.message);
  }
};


getAllSections();

const isAdding = ref(false);
const input = ref("");
const filteredSections = computed(() => {
  return sections.value.filter(section =>
    section.section.toLowerCase().includes(input.value.toLowerCase())
  );
});

const toggleEdit = (id) => {
  const section = sections.value.find((section) => section.id === id);
  if (section) {
    section.isEditing = !section.isEditing;
  }
};

const saveSection = async (section) => {
  try {
        const sectionToSave = {
          section_id: section.id,
          section_text: section.section,
        };

        console.log(sectionToSave);

        const response = await axiosInstance.post('/sections/save-section', sectionToSave, {
          headers: {
            'Content-Type': 'application/json',
          },
        });

        console.log('Section saved successfully:', response.data);
      } catch (error) {
        console.error('Error saving section:', error.response?.data || error.message);
      }
    };

const deleteSection = async (sectionIdToDelete) => {
  try {
        const sectionToDelete = {
          section_id: sectionIdToDelete,
        };

        console.log('Section to delete:', sectionToDelete);

        const response = await axiosInstance.post('/sections/delete-section', sectionToDelete, {
          headers: {
            'Content-Type': 'application/json',
          },
        });

        console.log('Section deleted successfully:', response.data);
      } catch (error) {
        console.error('Error deleting section:', error.response?.data || error.message);
        window.alert(error.response?.data?.message);
      }
    };



const saveEdit = (id, newSectionValue) => {
  const section = sections.value.find((section) => section.id === id);
  if (section) {
    section.section = newSectionValue;
    section.isEditing = false;
    
    //posli na backend
    saveSection(section)
    
  }
};

const deleteUser = (id) => {
  const isConfirmed = window.confirm("Ste si istý, že chcete odstrániť túto sekciu?");
  if (isConfirmed) {
    const index = sections.value.findIndex((section) => section.id === id);
    if (index !== -1) {
      sections.value.splice(index, 1);
      deleteSection(id)
    }
  }
};

const addSection = () => {
  const newId = sections.value.length > 0 ? sections.value[sections.value.length - 1].id + 1 : 1;
  sections.value.push({ id: newId, section: "", isEditing: true });
  isAdding.value = true;
};

const saveNewSection = (id, newSectionValue) => {
  if (newSectionValue.trim() === "") {
    window.alert("Názov sekcie nemôže byť prázdny");
    return;
  }
  const section = sections.value.find((section) => section.id === id);
  if (section) {
    section.section = newSectionValue;
    section.isEditing = false;
    isAdding.value = false;

    //posli na backend
    saveSection(section)
  }
};

const cancelNewSection = (id) => {
  const index = sections.value.findIndex((section) => section.id === id);
  if (index !== -1) {
    sections.value.splice(index, 1);
  }
  isAdding.value = false;
};
</script>

<template>
  <BaseLayout
    title="Správca Sekcií"
    :breadcrumb="[ 
      { label: 'Admin Rozhranie', route: '/pages/landing-pages/admin-control-panel' },
      { label: 'Správca Sekcií' },
    ]"
  >

  <div class="row pt-4 pb-4">
    <div class="col-6">
              <div class="row">
                <div class="col fst">
                <input class="searchbox" type="text" v-model="input" placeholder="Hľadať sekciu"/>
              </div>
              <div class="col-6 scnd">
                <div class="lupa">
              <i class="bi bi-search icon-color"></i>
            </div>
            </div>
            </div>
          </div>
        </div>

    <table class="table">
      <thead>
        <tr class="tr">
          <th scope="col"></th>
          <th scope="col"><div class="d-flex justify-content-center font">SEKCIA</div></th>
          <th scope="col"><div class="d-flex justify-content-center"></div></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="section in filteredSections" :key="section.id">
          <th scope="row">
            <div class="d-flex justify-content-center">{{ section.id }}</div>
          </th>

          <td>
            <div class="d-flex justify-content-center">
              <template v-if="section.isEditing">
                <input
                  type="text"
                  v-model="section.section"
                  @keyup.enter="section.isEditing ? saveEdit(section.id, section.section) : saveNewSection(section.id, section.section)"
                  class="form-control text-center"
                />
              </template>
              <template v-else>
                {{ section.section }}
              </template>
            </div>
          </td>

          <td class="td-btn">
            <div class="d-flex justify-content-center">
              <button
                v-if="!section.isEditing"
                class="btn btn-success mx-1"
                @click="toggleEdit(section.id)"
              >
                Upraviť
              </button>
              <button
                v-if="section.isEditing && !isAdding"
                class="btn btn-success mx-1"
                @click="saveEdit(section.id, section.section)"
              >
                Uložiť
              </button>
              <button
                v-if="section.isEditing && isAdding"
                class="btn btn-success mx-1"
                @click="saveNewSection(section.id, section.section)"
              >
                Uložiť
              </button>
              <button
                v-if="section.isEditing && isAdding"
                class="btn btn-danger mx-1"
                @click="cancelNewSection(section.id)"
              >
                Zrušiť
              </button>
              <button v-if="!section.isEditing" class="btn btn-danger mx-1" @click="deleteUser(section.id)">
                Odstrániť
              </button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
    <div class="d-flex justify-content-end mt-3">
      <button
        class="btn btn-success"
        @click="addSection"
        :disabled="isAdding"
      >
        Pridať Sekciu
      </button>
    </div>
  </BaseLayout>
</template>

<style scoped>
.btn {
  margin-bottom: 0 !important;
}

td {
  align-content: center !important;
}

.font {
  font-weight: 500;
  color: white;
}

table {
  border: solid;
  border-width: 0.1cap;
  border-color: #66bb6a;
}

.table thead th {
  border-bottom: #66bb6a !important;
}

.tr {
  background-color: #66bb6a;
}

.searchbox {
  border-top: none;
  border-left: none;
  border-right: none;
  border-bottom: solid;
  border-color: #66bb6a;
  width: 100% !important;
}

.btn-primary {
  background-color: #007bff;
  border-color: #007bff;
  color: white;
}

.btn-danger {
  background-color: #dc3545;
  border-color: #dc3545;
  color: white;
}

.mx-1 {
  margin-left: 0.25rem;
  margin-right: 0.25rem;
}

.form-control {
  width: 100%;
  max-width: 300px;
}
</style>

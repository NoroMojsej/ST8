<script setup>
  import { onMounted } from "vue";

  //example components
  import BaseLayout from "@/layouts/sections/components/BaseLayout.vue";
  //image
  import MaterialInput from "@/components/MaterialInput.vue";
  import MaterialButton from "@/components/MaterialButton.vue";
  import FileUpload from "@/views/LandingPages/Essay/components/FileUpload.vue";

  // material-input
  import setMaterialInput from "@/assets/js/material-input";
  onMounted(() => {
    setMaterialInput();
  });
</script>

<template>
  <BaseLayout
        title="Nahranie Práce"
        :breadcrumb="[
            { label: 'Domov', route: '/' },
            { label: 'Nahranie Práce' },]"
        >
      
        <div class="descriptive-div1">
          <div class="descriptive-div2">
              V tomto formulári môžete nahrať svoju vytvorenú prácu.
              Po vyplnení formuláru nahrajte 2 súbory - PDF a dokument Word.
              <br><br> <p class="p">DRŽÍME PALCE!</p>
          </div>
        </div>
      
      <div class="container">
        <div class="row">
          <div class="col-24 mx-auto">
            
              <div class="row">
                <div class="col-lg-7 col-md-7 z-index-2 position-relative px-md-2 px-sm-5 mx-auto">
                  <div class="row mt-4 mb-5 p-3 rounded shadow-sm bg-container">
                    <div class="mb-3">
                      <MaterialInput id="essay-title" class="input-group-static mt-2" label="NÁZOV PRÁCE"
                      type="name" placeholder="Názov Práce" />  
                    </div>
                    <div class="mb-3">
                      <label for="textarea2" class="form-label" style="color: #4CAF50;">ABSTRAKT ENG</label>
                      <textarea id="textarea2" class="form-control" style="box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.05);" rows="4" placeholder="Abstract..."></textarea>
                      <br/>
                      <label for="textarea3" class="form-label" style="color: #4CAF50;">ABSTRAKT SVK</label>
                      <textarea id="textarea3" class="form-control" style="box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.05);" rows="4" placeholder="Abstrakt..."></textarea>
                    </div>
                    <div class="mb-3">
                      <MaterialInput id="keywords-eng" class="input-group-static mt-2" label="KEYWORDS"
                      type="name" placeholder="Keywords" />  
                      <MaterialInput id="keywords-svk" class="input-group-static mt-2" label="KĽÚČOVÉ SLOVÁ"
                      type="name" placeholder="Kľúčové Slová" />  
                    </div>
                    <div class="mb-3">
                      <br/>
                      <label for="category" class="form-label" style="color: #4CAF50;">SEKCIA PRÁCE</label>
                      <select id="category" class="form-select" aria-label="Category">
                        <option selected disabled>Vyberte sekciu</option>
                        <!--Tieto údaje sa budú vkladať z databázy-->
                        <option value="essay">Kat1</option>
                        <option value="report">Kat2</option>
                        <option value="thesis">Kat3</option>
                        <option value="other">Kat4</option>
                      </select>
                    </div>
                  </div>

                  <FileUpload />

                  <div class="col-md-12 text-center">
                    <MaterialButton id=save-essay variant="outline" color="success" class="w-35 me-2 mt-3 mb-0 btn">PRIDAŤ PRÁCU
                    </MaterialButton>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>


  </BaseLayout>
</template>

<style scoped>
  .bg-container {
  background-color: rgba(223, 223, 223, 0.747);
  border-radius: 15px;
  padding: 20px;
  }
</style>
<script setup>
  import { onMounted } from "vue";

  //example components
  import DefaultNavbar from "@/examples/navbars/NavbarDefault.vue";
  import Header from "../../../examples/Header.vue";
  import DefaultFooter from "@/examples/footers/FooterDefault.vue";

  //image
  import image from "@/assets/img/essay.jpeg";

  import MaterialInput from "@/components/MaterialInput.vue";
  import MaterialButton from "@/components/MaterialButton.vue";
  import FileUpload from "@/components/FileUpload.vue";

  // material-input
  onMounted(() => {
    setMaterialInput();
  });
</script>

<template>
  <div class="container position-sticky z-index-sticky top-0">
    <div class="row">
      <div class="col-12">
        <DefaultNavbar :sticky="true"/>
      </div>
    </div>
  </div>

  <Header>
    <div
      class="page-header min-height-400 justify-content-center"
      :style="{ backgroundImage: `url(${image})` }"
      loading="lazy"
    >
      <span class="mask bg-gradient-dark opacity-8">
        <div class="mt-n4 pt-5 text-center">
          <div style="margin-top: 180px;">
            <h1 class="text-white mb-4">Nahranie Práce</h1>
          </div>
        </div>
      </span>
    </div>  
</Header>

  <div class="card card-body blur shadow-blur mx-3 mx-md-4 mb-4">
    <section class="py-sm-5 py-5 position-relative">
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
      </section>
    </div>
  <DefaultFooter />
</template>

<style scoped>
  .bg-container {
  background-color: rgba(194, 194, 194, 0.69);
  border-radius: 15px;
  padding: 20px;
  }
</style>
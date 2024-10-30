<script setup>
import { onMounted } from "vue";
import DefaultNavbar from "@/examples/navbars/NavbarDefault.vue";
import Header from "../../../examples/Header.vue";
import DefaultFooter from "@/examples/footers/FooterDefault.vue";
import image from "@/assets/img/essay.jpeg";
import MaterialInput from "@/components/MaterialInput.vue";
import MaterialButton from "@/components/MaterialButton.vue";
import FileUpload from "@/components/FileUpload.vue";

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
      class="page-header min-height-400"
      :style="{ backgroundImage: `url(${image})` }"
      loading="lazy"
    >
      <span class="mask bg-gradient-dark opacity-8"></span>
    </div>
  </Header>
  <div class="card card-body blur shadow-blur mx-3 mx-md-4 mt-n6 mb-4">
    <section class="py-sm-7 py-5 position-relative">
    <div class="container">
      <div class="row">
        <div class="col-12 mx-auto">
          <div id="essay-title" class="mt-n8 mt-md-n9 text-center">
            <h1 class="text-white mb-4">Názov Práce</h1>
          </div>
          <div class="row py-7">
            <div class="col-lg-7 col-md-7 z-index-2 position-relative px-md-2 px-sm-5 mx-auto">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 id="fakulta" class="mb-0">Fakulta</h3>
                <h3 id="katedra" class="mb-0">Katedra</h3>
                <h3 id="univerzita" class="mb-0">Univerzita</h3>
              </div>

              <div class="row mt-4 mb-5 p-3 rounded shadow-sm bg-light">
                <div class="col-md-6">
                  <label for="textarea1" class="form-label">ABSTRAKT ENG</label>
                  <textarea id="textarea1" class="form-control" rows="4" placeholder="Abstract..."></textarea>
                  <MaterialInput id="keywords-eng" class="input-group-static mt-2" label="KEYWORDS"
                      type="name" placeholder="Keywords" />  
                </div>
                <div class="col-md-6">
                  <label for="textarea2" class="form-label">ABSTRAKT SVK</label>
                  <textarea id="textarea2" class="form-control" rows="4" placeholder="Abstrakt..."></textarea>
                  <MaterialInput id="keywords-svk" class="input-group-static mt-2" label="KĽÚČOVÉ SLOVÁ"
                      type="name" placeholder="Kľúčové Slová" />  
                </div>
              </div>

              <FileUpload />

              <div class="col-md-12 text-center">
                <MaterialButton id=save-essay variant="outline" color="success" class="w-35 me-2 mt-3 mb-0 btn">ULOŽIŤ ZMENY
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

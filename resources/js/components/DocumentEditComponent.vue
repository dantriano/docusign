<template>
  <div class="container container-task">
    <form id="editDocument" @submit="save" method="post">
      <div class="row">
        <div class="col-md-12">
          <div class="mb-3 row">
            <label for="name" class="col-sm-2 col-form-label">{{
              this.lang.doc_name
            }}</label>
            <div class="col-sm-10">
              <input
                type="text"
                v-model="name"
                class="form-control"
                id="name"
                required
              />
            </div>
          </div>

          <div class="mb-3 row">
            <label for="type" class="col-sm-2 col-form-label">Tipo</label>
            <div class="col-sm-10">
              <select id="type" class="form-select" v-model="type">
                <option selected></option>
                <option value="1">
                  {{ this.lang.doc_type_form }}
                </option>
                <option value="2">
                  {{ this.lang.doc_type_multisign }}
                </option>
              </select>
            </div>
          </div>
          <div class="mb-3 row">
            <label for="document" class="col-sm-2 col-form-label">
              {{ this.lang.doc_sel_file }}</label
            >
            <div class="col-sm-10">
              <input
                class="form-control"
                type="file"
                id="document"
                ref="file"
                v-on:change="handleFileUpload()"
              />
            </div>
          </div>
          <div class="mb-3 row">
            <label for="desc" class="col-sm-2 col-form-label">{{
              this.lang.doc_desc
            }}</label>
            <div class="col-sm-10">
              <textarea
                v-model="desc"
                class="form-control"
                id="desc"
              ></textarea>
            </div>
          </div>
          <div class="mb-3 d-grid gap-2 d-md-flex justify-content-md-end">
            <div class="d-flex justify-content-end d-md-block">
              <button type="submit" class="btn btn-success btn-sm text-white">
                <span v-if="isNew">Añadir</span>
                <span v-else>Actualizar</span>
              </button>

              <!-- Botón que limpia el formulario y inicializa la variable a 0, solo se muestra si la variable update es diferente a 0-->
              <button
                @click="back()"
                class="btn btn-secondary btn-sm text-white"
              >
                Atrás
              </button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</template>
<script>
export default {
  props: {
    id: {
      Type: Number,
      default: null,
    },
    user_id: {
      Type: Number,
    },
    lang: {},
  },
  data() {
    return {
      isNew: this.id == null,
      name: "",
      desc: "",
      type: "",
      file: "",
      URI: "/documentos",
      arrayType: [],
      params: this.$route.params,
    };
  },
  methods: {
    handleFileUpload() {
      this.file = this.$refs.file.files[0];
      console.log(this.file);
    },
    success: function (response) {
      window.location.href = "/documentos";
    },
    errorCatch: function (error) {
      console.log(error);
    },
    get() {
      let me = this;
      let url = me.URI + "/get/" + me.id; //Ruta que hemos creado para que nos devuelva todas las tareas
      axios
        .get(url)
        .then(function (response) {
          let res = response.data.res;
          me.name = res.name;
          me.desc = res.desc;
          me.type = res.type;
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    getFormData() {
      let data = {
        _method: this.isNew ? "POST" : "PUT",
        user_id: this.user_id,
        name: this.name,
        desc: this.desc,
        type: this.type,
      };
      const formData = new FormData();
      Object.entries(data).forEach(([key, value]) => {
        formData.append(key, value);
      });
      this.file = this.$refs.file.files[0];
      if (this.file) formData.append("file", this.file);
      if (!this.isNew) formData.append("id", this.id);
      return formData;
    },
    save: function (e) {
      e.preventDefault();
      let me = this;
      let url = me.URI;
      let header = {
        headers: {
          "Content-Type": "multipart/form-data",
        },
      };
      let formData = this.getFormData();
      axios.post(url, formData).then(this.success).catch(this.errorCatch);
    },
    back() {
      this.$router.go(-1);
    },
  },
  mounted() {
    //console.log(this.$router);
    //console.log(this.$router.getRoutes());

    if (!this.isNew) {
      this.get();
    }
  },
};
</script>
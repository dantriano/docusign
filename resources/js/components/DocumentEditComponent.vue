<template>
  <div class="container container-task">
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <!-- Formulario para la creación o modificación de nuestras tareas-->
          <label>ID</label>
          <input v-model="id" type="text" class="form-control" />
          <!-- Formulario para la creación o modificación de nuestras tareas-->
          <label>Nombre</label>
          <input v-model="name" type="text" class="form-control" />

          <label>Descripción</label>
          <input v-model="desc" type="text" class="form-control" />
        </div>
        <div class="container-buttons">
          <!-- Botón que añade los datos del formulario, solo se muestra si la variable update es igual a 0-->
          <button
            v-if="edit == 0"
            @click="save()"
            class="btn btn-success btn-sm me-1 text-white"
          >
            Añadir
          </button>
          <!-- Botón que modifica la tarea que anteriormente hemos seleccionado, solo se muestra si la variable update es diferente a 0-->
          <button
            v-if="edit != 0"
            @click="update()"
            class="btn btn-success btn-sm me-1 text-white"
          >
            Actualizar
          </button>
          <!-- Botón que limpia el formulario y inicializa la variable a 0, solo se muestra si la variable update es diferente a 0-->
          <button v-if="edit != 0" @click="back()" class="btn">
            Atrás
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: ["edit"],
  data() {
    return {
      name: "", //Esta variable, mediante v-model esta relacionada con el input del formulario
      desc: "", //Esta variable, mediante v-model esta relacionada con el input del formulario
      id: this.edit ? this.edit : 0,
      URI: "/documentos",
      arrayDocs: [], //Este array contendrá las tareas de nuestra bd
      params: this.$route.params, //Este array contendrá las tareas de nuestra bd
    };
  },
  methods: {
    get() {
      let me = this;
      let url = me.URI + "/get/" + me.id; //Ruta que hemos creado para que nos devuelva todas las tareas
      axios
        .get(url)
        .then(function (response) {
          var res = response.data.res;
          me.id = res.id;
          me.name = res.name;
          me.desc = res.desc;
        })
        .catch(function (error) {
          // handle error
          console.log(error);
        });
    },
    save() {
      let me = this;
      let url = me.URI;
      axios
        .post(url, {
          name: this.name,
          desc: this.desc,
        })
        .then(function (response) {
          window.location.href = '/documentos';
          if (response.status == "201") console.log("Correcto");
          me.id = response.data.id;
          me.get();
          me.clearFields();
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    update() {
      let me = this;
      let url = me.URI;
      axios
        .put(url, {
          id: this.id,
          name: this.name,
          desc: this.desc,
        })
        .then(function (response) {
          window.location.href = '/documentos';
          me.get(); //llamamos al metodo getTask(); para que refresque nuestro array y muestro los nuevos datos
          me.clearFields(); //Limpiamos los campos e inicializamos la variable update a 0
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    loadFieldsUpdate(data) {
      //Esta función rellena los campos y la variable update, con la tarea que queremos modificar
      this.update = data.id;
      let me = this;
      let url = "/tareas/buscar?id=" + this.update;
      axios
        .get(url)
        .then(function (response) {
          me.name = response.data.name;
          me.description = response.data.description;
          me.content = response.data.content;
        })
        .catch(function (error) {
          // handle error
          console.log(error);
        });
    },
    back() {
      this.$router.go(-1);
    },
  },
  mounted() {
    console.log(this.$router);
    console.log(this.$router.getRoutes());
    if (this.edit) {
      this.id = this.edit;
      this.get();
    }
    //this.show();
  },
};
</script>
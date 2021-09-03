<template>
  <table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Nom</th>
        <th scope="col">Descripcio</th>
        <th scope="col">Opcions</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(doc, key) in arrayDocs" :key="doc.id">
        <th scope="row" v-text="key + 1"></th>
        <td v-text="doc.name"></td>
        <td v-text="doc.desc"></td>
        <td>
          <button
            type="button"
            class="btn btn-success btn-sm me-1 text-white"
            @click="manager(doc)"
          >
            Gestionar</button
          ><button
            type="button"
            class="btn btn-primary btn-sm me-1 text-white"
            @click="view(doc)"
          >
            Editar</button
          ><button
            type="button"
            class="btn btn-danger btn-sm text-white"
            @click="deleteOne(doc)"
          >
            Borrar
          </button>
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script>
export default {
  props: ["user"],
  data() {
    return {
      user_id: this.user ? this.user : 0,
      arrayDocs: [], //Este array contendrá las tareas de nuestra bd
    };
  },
  mounted() {
    console.log("Component mounted.");
    this.getAll();
  },
  methods: {
    getAll() {
      let me = this;
      let url = "/documentos/list"; //Ruta que hemos creado para que nos devuelva todas las tareas
      axios
        .get(url)
        .then(function (response) {
          console.log(response);
          //creamos un array y guardamos el contenido que nos devuelve el response
          me.arrayDocs = response.data.res;
        })
        .catch(function (error) {
          // handle error
          console.log(error);
        });
    },
    view(data) {
      window.location.href = "/documentos/edit/" + data.id;
    },
    manager(data) {
      console.log(1)
      window.location.href = "/documentos/manager/" + data.id;
    },
    deleteOne(data) {
      //Esta nos abrirá un alert de javascript y si aceptamos borrará la tarea que hemos elegido
      let me = this;
      let doc_id = data.id;
      if (confirm("¿Seguro que deseas borrar esta tarea?")) {
        axios
          .delete("/documentos/" + doc_id)
          .then(function (response) {
            me.getAll();
          })
          .catch(function (error) {
            console.log(error);
          });
      }
    },
  },
};
</script>

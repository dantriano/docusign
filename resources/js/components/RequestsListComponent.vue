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
      <tr v-for="(req, key) in arrayDocs" :key="req.id">
        <th scope="row" v-text="key + 1"></th>
        <td v-text="req.name"></td>
        <td v-text="req.desc"></td>
        <td>
        <button v-if="pending"
            type="button"
            class="btn btn-success btn-sm me-1 text-white"
            @click="sign(req)"
          >
            Firmar
          </button>
          <button v-else
            type="button"
            class="btn btn-success btn-sm me-1 text-white"
            @click="show(req)"
          >
            Ver
          </button>
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script>
export default {
  props: ["user","status"],
  data() {
    return {
      user_id: this.user ? this.user : 0,
      pending: (status===0),
      arrayDocs: [], //Este array contendrá las tareas de nuestra bd
    };
  },
  mounted() {
    console.log("Component mounted.");
    this.getRequests();
  },
  methods: {
    sign(data) {
      window.location.href = "/peticiones/firma/view/" + data.request_id;
    },
    show(data) {
      window.location.href = "/peticiones/firma/view/" + data.request_id;
    },
    getRequests() {
      let me = this;
      let url = "/requests/user/" + me.user_id; //Ruta que hemos creado para que nos devuelva todas las tareas
      axios
        .get(url, {
          params: {
            status: me.status,
          },
        })
        .then(function (response) {
          console.log(response);
          me.arrayDocs = response.data.res;
        })
        .catch(function (error) {
          console.log(error);
        });
    },
  },
};
</script>

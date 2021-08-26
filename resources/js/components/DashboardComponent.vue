<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12" style="">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item" role="presentation">
            <button
              class="nav-link active"
              id="home-tab"
              data-bs-toggle="tab"
              data-bs-target="#pendents"
              type="button"
              role="tab"
              aria-controls="home"
              aria-selected="true"
            >
              Pendents
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button
              class="nav-link"
              id="all-tab"
              data-bs-toggle="tab"
              data-bs-target="#all"
              type="button"
              role="tab"
              aria-controls="all"
              aria-selected="false"
            >
              Tots els documents
            </button>
          </li>
        </ul>
        <div class="tab-content" id="myTabContent">
          <div
            class="tab-pane fade show active"
            id="pendents"
            role="tabpanel"
            aria-labelledby="pendents-tab"
          >
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
                <tr>
                  <th scope="row">1</th>
                  <td>Mark</td>
                  <td>Otto</td>
                  <td><button type="button" class="btn btn-success btn-sm me-1 text-white">Firmar</button><button type="button" class="btn btn-primary btn-sm me-1 text-white">Veure</button><button type="button" class="btn btn-danger btn-sm text-white">Esborrar</button></td>
                </tr>
                <tr>
                  <th scope="row">2</th>
                  <td>Jacob</td>
                  <td>Thornton</td>
                  <td>@fat</td>
                </tr>
                <tr>
                  <th scope="row">3</th>
                  <td colspan="2">Larry the Bird</td>
                  <td>@twitter</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div
            class="tab-pane fade"
            id="all"
            role="tabpanel"
            aria-labelledby="all-tab"
          >
            ...
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
    console.log("Component mounted.");
  },
};
</script>

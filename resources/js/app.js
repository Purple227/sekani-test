/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

 require('./bootstrap');

 window.Vue = require('vue');


 import axios from 'axios';
 import VueAxios from 'vue-axios'; 

 Vue.use(VueAxios, axios);

 import XLSX from 'xlsx';

 const app = new Vue({

  el: '#app',
  components: { 
    // Local components here e.g below
  },


  data() {

    return{

      date: new Date(),

      excel: {
        name: null,
        file: null,
        data: null,
        error: null,
        status: false
      },

      loader: {
        button: false,
        page: false,
      },

      clientPagination: {
        nextPageUrl: null,
        previousPageUrl: null, 
        to: null,
        total: null,
        loader: false
      },

      clientData: null,
      searchResult: [],
      searchQuery: '',

    }

  },



  mounted() {
    this.getClientData()
  },

  methods: { //Method calibrace open

    fileUpload(e) {
      this.excel.name = e.target.files[0].name
      this.excel.file = e.target.files[0]
    },

    getExcelData() {
      this.loader.button = true
     if (this.excel.file) {
      console.log("Outside...");
       var fileReader = new FileReader();
        fileReader.onload = function(event) {
        var data = event.target.result;
        console.log('inside...')

        var workbook = XLSX.read(data, {
          type: "binary"
        });

        workbook.SheetNames.forEach(sheet => {
          let rowObject = XLSX.utils.sheet_to_row_object_array(
            workbook.Sheets[sheet]
            );

          window.jsonData = JSON.stringify(rowObject);
          console.log(jsonData)
        });

      };

      fileReader.readAsBinaryString(this.excel.file);

       setTimeout(() => {
        this.saveExcelData(window.jsonData)
        console.log('purple win')
      }, 8000)
    }

  },


  saveExcelData(excelData) {
    this.loader.page = true
    Vue.axios.all([
     axios.post('api/account', {
       excel_data: excelData
     }), 
     axios.post('api/client', {
       excel_data: excelData
     })
     ])
    .then(axios.spread((data1, data2) => {
      console.log('data1', data1, 'data2', data2)
      this.loader.button = false
      this.loader.page = false
      this.excel.status = true
      this.getClientData()
    }))
    .catch(error => {
      console.log(error);
      this.loader.button = false
      this.loader.page = false
      this.excel.error = " Sorry there was an error processng your file"
    });
  },


  getClientData(api) {
    this.clientPagination.loader = true
    let api_url = api || '/api/client' 
    Vue.axios
    .get(api_url).then((response) => {
      this.clientData = response.data.data

      let nextPageUrl = response.data.next_page_url
      this.clientPagination.nextPageUrl = nextPageUrl 

      let previousPageUrl = response.data.prev_page_url
      this.clientPagination.previousPageUrl =  previousPageUrl 

      this.clientPagination.to = response.data.to
      this.clientPagination.total = response.data.total
      this.clientPagination.loader = false
    })
  },

  searchClient() {
    this.searchResult= []
    if(this.searchQuery.length > 1) {
      axios.get('/api/client/search',{params: { search_query: this.searchQuery }}).then(response => {
        this.searchResult = response.data
      });
    }
  },



  }, //Method calibrace close


computed: { // Computed calibrace open



} // Computed calibrace open



});

    <template>
  <div class="about">
    <h1>{{ error }}</h1>
  <div class="container">
    <h1>URL List</h1>
      <table class="table table-bordered">
        <tr>
          <th>SI</th>
          <th>Input URL</th>
          <th>Short URL</th>
        </tr>

        <tr v-for="(item, index) in info" :key="item.id">
          <td>{{ index }}</td>
          <td align="left">{{ item.inputUrl }}</td>
          <td>
            <a :href="item.baseUrl + '/' +item.hashKey">
          {{ item.baseUrl }}/{{ item.hashKey}}</a></td>
        </tr>
      </table>
  </div>
  </div>
</template>


<script>
  import axios from "axios";    //////////////// Axios Using for data send and receive with server

  export default {
    name: 'Urllist',  
    data(){
      return{
        error: '',
        info: []
      }
    },
    mounted() {
            this.getUrls();
        },
    methods:{   
    getUrls() {
          axios.get(`http://127.0.0.1:8000/`).then((response) => {     //////////////// Fatch all URL data form server
              if(response.data.success){
                this.info = response.data.data;
                console.log(this.info);
              }
              else{
                this.error = 'URL Data Not Found';
                console.log(this.error);
              }            
          });
      },
    },
  };
</script>
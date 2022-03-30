    <template>
  <div class="about">
    <h1>{{ error }}</h1>
  <div class="container">
    <h1>URL List</h1>
      <table class="table table-bordered">
        <tr>
          <th>SI</th>
          <th>URL</th>
          <th>Short URL</th>
        </tr>

        <tr v-for="(item, index) in info" :key="item.id">
          <td>{{ index }}</td>
          <td>{{ item.url_userdefine }}</td>
          <td>
            <a :href="item.url_baseurl + '/' +item.url_shortcode">
          {{ item.url_baseurl }}/{{ item.url_shortcode}}</a></td>
        </tr>
      </table>
  </div>
  </div>
</template>


<script>
import axios from "axios";

export default {
  name: 'Urllist',  
  data(){
    return{
      error: '',
      info: [],
      loading: true,
      errored: false,
    }
  },
  mounted() {
          this.getUrls();
      },
  methods:{   
  getUrls() {
        axios.get(`http://127.0.0.1:8000/dir/urlshortner`).then((res) => {
            if(res.data.success){
              this.info = res.data.data;
              console.log(this.info);
            }
            else{
              this.error = 'Data Not Found';
              console.log(this.error);
            }
            
        });
    },
  },
};
</script>
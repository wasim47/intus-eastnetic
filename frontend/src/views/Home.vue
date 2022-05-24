<template>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="shortcut icon" type="image/png" href="../assets/favicon.jpg"/>
    <title>My Vue.js app</title>
  </head>
    <body>

       <div class="home">
        <div class="container">      
          <img alt="Vue logo" src="../assets/logo.png" style="width:300px; height:auto">
          <h1>Welcome to EastNetic interview process fo PHP Developer</h1>
          <p>URL Shortner Project using PHP Laravel and Vuejs</p>
                    
          <div class="row">
            <div class="col-sm-6"><h2>URL Shortner</h2></div>
            <div class="col-sm-6"><h2><a href="/urllist">URL List</a></h2></div>
          </div>
          <div class="col-sm-12">
            <form @submit.prevent="urlShortner">
            <div class="row">
              
                <div class="col-sm-2"><label for="inputUrl">Enter Valid URL</label> </div>
                <div class="col-sm-8">
                  <input type="text" class="form-control" v-model="form.inputUrl" id="inputUrl" placeholder="Ex: https://www.eastnetic.com/">
                </div>
                <div class="col-sm-2"><button type="submit" class="btn btn-success">Submit</button></div>
              
              <div id="myId" ref="myId"></div>
            </div>
            </form>        
          </div>
        </div>
      </div>
    </body>
</html>
 
</template>

<script>
import axios from "axios";

export default {
  name: 'Home',  
  data(){
    return{
      error:[],
      form:{
        inputUrl: "",
      }
    }
  },

  methods:{  
    urlShortner: function(e){
      let axiosConfig = {
        headers: {                ///////////////////////////// Header using for Cros controll
            'Content-Type': 'application/json;charset=UTF-8',
            "Access-Control-Allow-Origin": "*",
            "Access-Control-Allow-Headers":"X-CSRF-TOKEN",
            "X-CSRF-TOKEN": "BRj9Op1PGK5Ur4BtalJTBs034lw3phOL5v77AxIq",
            'Access-Control-Allow-Credentials':true
        }
      };
      axios.post("http://127.0.0.1:8000/url/store",    //////////////// Posting user define url to server
        this.form, 
        axiosConfig)
        .then(
          function(response){
            if(response.data.success){
              console.log(response.data); 
              alert(response.data.message);
            }
            else{              
              console.log(response.data);    
              alert(response.data);
            }
            
          })
          .catch(function(error){            
            console.log(error);
            alert('Something wrong! Plese Check our API request');
          });
          e.target.reset();
    },
  },
};
</script>


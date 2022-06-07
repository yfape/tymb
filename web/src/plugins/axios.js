"use strict";

import Vue from 'vue';
import axios from "axios";
import main from '../main.js';

// Full config:  https://github.com/axios/axios#request-config
// axios.defaults.baseURL = process.env.baseURL || process.env.apiUrl || '';
// axios.defaults.headers.common['Authorization'] = AUTH_TOKEN;
axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded,multipart/form-data';

let config = {
  baseURL: 'http://ty_data.scdaily.net/'
  // timeout: 60 * 1000, // Timeout
  // withCredentials: true, // Check cross-site Access-Control
};

const _axios = axios.create(config);

_axios.interceptors.request.use(
  function(config) {
    // Do something before request is sent
    config.headers['Authorization'] = main.$store.state.token
    config.headers['openid'] = main.$store.state.user.openid
    main.$store.state.loading = true
    return config;
  },
  function(error) {
    // Do something with request error
    return Promise.reject(error);
  }
);

// Add a response interceptor
_axios.interceptors.response.use(
  function(response) {
    main.AItip(response.data.msg)
    main.$store.state.loading = false
    return response.data.data;
  },
  function(error) {
    main.$store.state.loading = false
    if(error.response.status == 999){
      main.AItip(error.response.data.msg,true)
      return Promise.reject(error);
    }else if(error.response.status == 998){
      main.AItip(error.response.data.msg,true)
      main.$router.push('/wxauth');
    }else if(error.response.status == 997){
      main.AItip('请先填写您的基本资料',true)
      main.$router.push('/auth');
    }else if(error.response.status == 996){
      main.AItip('请先加入代表团',true)
      main.$router.push('/noteam');
    }else{
      main.AItip(error,true)
      return Promise.reject(error);
    }
  }
);

Plugin.install = function(Vue, options) {
  Vue.axios = _axios;
  window.axios = _axios;
  Object.defineProperties(Vue.prototype, {
    axios: {
      get() {
        return _axios;
      }
    },
    $axios: {
      get() {
        return _axios;
      }
    },
  });
};

Vue.use(Plugin)

export default Plugin;

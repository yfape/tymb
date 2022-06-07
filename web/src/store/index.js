import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
  	system:{
  		appid: 'wxae2e1e4abe0da259',
  		redirect_uri: "http://ty.scdaily.net/",
      url: "http://ty.scdaily.net/",
      wxnews:'https://mp.weixin.qq.com/mp/profile_ext?action=home&__biz=MjM5OTM3NDE2NQ==&scene=124#wechat_redirect'
  	},
    // system:{
    //   appid: 'wxae2e1e4abe0da259',
    //   redirect_uri: "http://10.100.80.212/",
    //   url: "http://10.100.80.212/",
    //   wxnews:'https://mp.weixin.qq.com/mp/profile_ext?action=home&__biz=MjM5OTM3NDE2NQ==&scene=124#wechat_redirect'
    // },
    user:{},userinfo:{},jsapi:{},subjects:[],
    token:'',
    loading:false,
    color:[
      'yellow-8','blue-7','grey-7','grey-4',
      'orange-10','orange-9','orange-4',
      'blue-9','light-blue-7','light-blue-4','red-8'
    ],
    wx:'',
  },
  mutations: {
  },
  actions: {
  },
  modules: {
  }
})

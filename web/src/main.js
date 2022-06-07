import Vue from 'vue'
import './plugins/axios'
import App from './App.vue'
import './quasar'
import router from './router'
import store from './store'

Vue.config.productionTip = false

Vue.prototype.getUrlKey = function (name) {
  return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.href) || [, ""])[1].replace(/\+/g, '%20')) || null
}
Vue.prototype.lStorage = function(name,data=''){
  if(data){
    localStorage.setItem(name,JSON.stringify(data))
    return true
  }else{
    return localStorage.getItem(name)?JSON.parse(localStorage.getItem(name)):false
  }
}
Vue.prototype.changeURLArg = function(url,arg,arg_val){
    var pattern=arg+'=([^&]*)';
    var replaceText=arg+'='+arg_val; 
    if(url.match(pattern)){
        var tmp='/('+ arg+'=)([^&]*)/gi';
        tmp=url.replace(eval(tmp),replaceText);
        return tmp;
    }else{ 
        if(url.match('[\?]')){ 
            return url+'&'+replaceText; 
        }else{ 
            return url+'?'+replaceText; 
        } 
    }
}
Vue.prototype.AItip = function(title,error,actions){
  if(!title){
    return
  }
  this.$q.notify({
      message: title,
      position: 'top',
      html: true,
      timeout:actions?0:2000,
      color: error?'red-8':'blue-7',
      actions:actions
  })
}
Vue.prototype.df = function(timestamp){
  var date = new Date(timestamp * 1000);//时间戳为10位需*1000，时间戳为13位的话不需乘1000
    var Y = date.getFullYear() + '-';
    var M = (date.getMonth() + 1 < 10 ? '0' + (date.getMonth() + 1) : date.getMonth() + 1) + '-';
    var D = date.getDate() + ' ';
    // var h = date.getHours() + ':';
    // var m = date.getMinutes() + ':';
    // var s = date.getSeconds();
    return Y+M+D;
}
Vue.prototype.dtf = function(timestamp){
  var date = new Date(timestamp * 1000);//时间戳为10位需*1000，时间戳为13位的话不需乘1000
    var Y = date.getFullYear() + '年';
    var M = (date.getMonth() + 1 < 10 ? '0' + (date.getMonth() + 1) : date.getMonth() + 1) + '月';
    var D = date.getDate() + '日';
    var h = date.getHours() + '时';
    // var m = date.getMinutes() + ':';
    // var s = date.getSeconds();
    return Y+M+D+h;
}
Vue.prototype.goUrl = function(url){
  if(!url){
    return
  }
  if(url.indexOf('http')>-1){
    window.location.href = url
  }else{
    this.router.push(url)
  }
}
Vue.prototype.IdCodeValid = function(code){
  var city={11:"北京",12:"天津",13:"河北",14:"山西",15:"内蒙古",21:"辽宁",22:"吉林",23:"黑龙江 ",31:"上海",32:"江苏",33:"浙江",34:"安徽",35:"福建",36:"江西",37:"山东",41:"河南",42:"湖北 ",43:"湖南",44:"广东",45:"广西",46:"海南",50:"重庆",51:"四川",52:"贵州",53:"云南",54:"西藏 ",61:"陕西",62:"甘肃",63:"青海",64:"宁夏",65:"新疆",71:"台湾",81:"香港",82:"澳门",91:"国外 "};
  var row={
      'pass':true,
      'msg':'验证成功'
  };
  if(!code || !/^\d{6}(18|19|20)?\d{2}(0[1-9]|1[012])(0[1-9]|[12]\d|3[01])\d{3}(\d|[xX])$/.test(code)){
      row={
          'pass':false,
          'msg':'身份证号格式错误'
      };
  }else if(!city[code.substr(0,2)]){
      row={
          'pass':false,
          'msg':'身份证号地址编码错误'
      };
  }else{
      //18位身份证需要验证最后一位校验位
      if(code.length == 18){
          code = code.split('');
          //∑(ai×Wi)(mod 11)
          //加权因子
          var factor = [ 7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2 ];
          //校验位
          var parity = [ 1, 0, 'X', 9, 8, 7, 6, 5, 4, 3, 2 ];
          var sum = 0;
          var ai = 0;
          var wi = 0;
          for (var i = 0; i < 17; i++)
          {
              ai = code[i];
              wi = factor[i];
              sum += ai * wi;
          }
          if(parity[sum % 11] != code[17].toUpperCase()){
              row={
                  'pass':false,
                  'msg':'身份证号校验位错误'
              };
          }
      }
  }
  return row;
}

Vue.prototype.getSub = function(sid){
  let arr = this.$store.state.subjects
  for(let i in arr){
    if(arr[i].sid == sid){
      return arr[i]
    }
  }
}

var vue = new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')

export default vue

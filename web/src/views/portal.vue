<template>
  <q-layout view="hHh lpR fFf" v-if="show">

    <q-page-container>
      <router-view />
    </q-page-container>

	<footer1 ref="footer1"/>    
  </q-layout>
</template> 
<script>
import footer1 from '@/components/footer1'
import wx from 'weixin-js-sdk';
export default{
name:'portal',
props:[],
components:{footer1},
data(){return {
	show:true,
}},
mounted(){
	let store = this.$store.state
	wx.config({
	  	debug: false,
	  	appId: 'wxae2e1e4abe0da259',
	  	timestamp: this.$store.state.jsapi.timestamp, // 必填，生成签名的时间戳
	  	nonceStr: this.$store.state.jsapi.noncestr, // 必填，生成签名的随机串
	  	signature: this.$store.state.jsapi.signature,// 必填，签名
	  	jsApiList: ['updateAppMessageShareData'] // 必填，需要使用的JS接口列表
	});
	wx.ready(function () {   //需在用户可能点击分享按钮前就先调用
		wx.updateAppMessageShareData({ 
		    title: '四川省体育活动中心-线上竞赛', // 分享标题
		    desc: '', // 分享描述
		    link: store.system.redirect_uri+'#/', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
		    imgUrl: store.user.headimgurl, // 分享图标
		    success: function () {
		      // 设置成功
		    }
		})
	});
	this.$store.state.wx.ready()
},
methods:{

},
watch:{},
destroy(){},
}
</script>
<style scoped>

</style>
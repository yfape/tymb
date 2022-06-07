<template><div class="text-grey-5 text-body2 text-center q-py-lg">
	请求微信授权
</div></template>
<script>
export default{
name:'wxauth',
props:[],
components:{},
data(){return {

}},
mounted(){
	this.getAuth()
},
methods:{
	getAuth(){
		let url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='+this.$store.state.system.appid+'&redirect_uri='+this.$store.state.system.redirect_uri+'&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect'
		window.location.href = url
	}
},
watch:{},
destroy(){},
}
</script>
<style scoped>

</style>
<template><div class="text-grey-5 text-center text-body-2 q-py-lg">
	登录中
</div></template>
<script>
export default{
name:'login',
props:['code'],
components:{},
data(){return {

}},
mounted(){
	this.getUser()
},
methods:{
	getUser(){
		if(!this.code){
			this.$router.replace('/wxauth')
		}
		this.axios.post('login',{code:this.code}).then(res=>{
			this.saveToken(res.token)
			this.saveUser(res.user)
			this.saveJsapi(res.jsapi)
			this.saveSubjects(res.subjects)
			this.$router.replace('/')
		})
	},
	saveToken(token){
		this.$store.state.token = token
		// this.lStorage('token', token)
	},
	saveUser(user){
		this.$store.state.user = Object.assign({},{},user)
		// this.lStorage('user', user)
	},
	saveJsapi(jsapi){
		this.$store.state.jsapi = Object.assign({},{},jsapi)
	},
	saveSubjects(subs){
		this.$store.state.subjects = Object.assign([],[],subs)
	}
},
watch:{},
destroy(){},
}
</script>
<style scoped>

</style>
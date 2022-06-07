<template><div  @click="openfileselect" style="position: relative;background-color:transparent;">
	<svg v-if="!video" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="black" width="50px" height="50px">
		<path d="M0 0h24v24H0V0z" fill="none"/>
		<path d="M12 4c-4.41 0-8 3.59-8 8s3.59 8 8 8 8-3.59 8-8-3.59-8-8-8zm5 9h-4v4h-2v-4H7v-2h4V7h2v4h4v2z" opacity="1" fill="#FBC02D"/>
		<path d="M13 7h-2v4H7v2h4v4h2v-4h4v-2h-4zm-1-5C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
	</svg>
	<svg v-else xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="black" width="50px" height="50px">
		<path d="M0 0h24v24H0V0z" fill="none"/>
		<path d="M20 2h-8C6.38 2 2 6.66 2 12.28 2 17.5 6.49 22 11.72 22 17.39 22 22 17.62 22 12V4c0-1.1-.9-2-2-2zm-3 13l-3-2v2H7V9h7v2l3-2v6z" fill="#FBC02D"/>
	</svg>

	<input multiple type="file" :val="file" :id="id" hidden @change="updateFile" :accept="type"/>
</div></template>
<script>
export default{
name:'upload2',
components:{},
props:['video'],
data(){return {
	id:'video',limit:2,file:'',
	type:'video/*',verified:'',
}},
mounted(){
	this.id = Math.random().toString(36).slice(2);
},
methods:{
	openfileselect(){
		let file = document.getElementById(this.id);
       	file.click();
	},
	duageFileSize(file){
		if(file.size/1024/1024/100 >= this.limit){
			return false;
		}else{
			return true;
		}
	},
	updateFile(){
		var filed = document.getElementById(this.id);
		
		if(!this.duageFileSize(filed.files[0])){
			this.AItip('文件大于100Mb，请压缩后上传');
			filed.value = ''
			return;
		}
		this.$emit('change',filed.files[0])
		filed.value = ''
	},
},
watch:{},
destroy(){},
}
</script>
<style scoped>

</style>
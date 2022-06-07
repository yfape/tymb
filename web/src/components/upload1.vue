<template><div  @click="openfileselect" style="position: relative;background-color:transparent;">
	<q-img v-if="img" :ratio="16/9" :src="img" class="full-width full-height" style="position:relative;z-index:-1"/>
	<div v-else class="full-width full-height row items-center justify-center" style="position:relative;z-index:-1">
		<q-btn label="添加代表团旗帜" icon="o_add" outline color="white"/>
	</div>
	<input multiple type="file" :val="file" :id="id" hidden @change="updateFile" :accept="type"/>
</div></template>
<script>
export default{
name:'upload1',
components:{},
props:['intro','img'],
data(){return {
	id:'image',limit:2,file:'',
	type:'image/jpeg,image/png,image/x-icon,image/gif,',
}},
mounted(){
	this.id = Math.random().toString(36).slice(2);
},
methods:{
	openfileselect(){
		let file = document.getElementById(this.id);
       	file.click();
	},
	duageFileType(file){
		let res = this.type.indexOf(file.type)
		if(res>=0){
			return true
		}else{
			return false
		}
	},
	duageFileSize(file){
		if(file.size/1024/100 >= this.limit){
			return false;
		}else{
			return true;
		}
	},
	updateFile(){
		var param = new FormData();
		var filed = document.getElementById(this.id);
		
		if(!this.duageFileSize(filed.files[0])){
			this.AItip('文件大于100kb，请压缩后上传');
			filed.value = ''
			return;
		}
		if(!this.duageFileType(filed.files[0])){
			this.AItip('文件格式不被允许');
			filed.value = ''
			return;
		}
		param.append("file",filed.files[0]);
		filed.value = ''
		this.axios.post('upload',param).then(response=>{
			this.uploadbackIn(response)
			this.$q.loading.hide()
		}).catch(err=>{
			this.$q.loading.hide()
		})
	},
	uploadbackIn(imgs){
		this.$emit('update:img',imgs)
		this.$emit('reflesh')
	},
},
watch:{},
destroy(){},
}
</script>
<style scoped>

</style>
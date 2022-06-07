<template><div>
	
	<div class="wl q-px-lg" style="position:absolute;width:100%;height:300px;margin:auto;top:0;bottom:0;">
		<q-img src="/image/null2.png" style="width:150px"/>
		<div class="text-grey text-caption q-mt-sm q-mb-lg">未加入任何代表团</div>
		<q-btn label="加入代表团" outline dense class="q-mb-md" style="width:200px;" @click="$router.push('/teamlist')"/>
		<q-btn label="创建代表团" outline dense class="q-mb-md" style="width:200px;" @click="$router.push('/createteam')"/>
	</div>

</div></template>
<script>
export default{
name:'noteam',
components:{},
data(){return {

}},
mounted(){},
methods:{},
watch:{},
destroy(){},
}
</script>
<style scoped>

</style>
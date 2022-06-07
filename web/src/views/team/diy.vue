<template><div>
	<div style="position:absolute;z-index:-1;height:200px;width:100%;box-shadow:inset -1px -1px 8px #9B9B9B;" class="bg-yellow-7"></div>
	<upload1 style="height:200px;width:100%;"/>
	<div style="height:80px;position:absolute;top:160px;width:100%;overflow:visible;" class="wl row items-center q-px-md">
		<div class="col-8 full-height text-left">
			<div style="padding-top:40px;" class="full-height text-subtitle1 row items-center">
				<div>{{$store.state.user.nickname}}</div>
			</div>
		</div>
		<div class="col-4 full-height text-right">
			<q-img :src="$store.state.user.headimgurl" :ratio="1" style="width:80px;border-radius:100%;box-shadow:0px -1px 5px #9B9B9B;" class="shadow-1 q-pa-xs"/>
		</div>
	</div>

	<div style="margin-top:40px">
		


	</div>
</div></template>
<script>
import upload1 from '@/components/upload1'
export default{
name:'create',
props:[],
components:{upload1},
data(){return {
	team:{name:'',headimg:''}
}},
mounted(){},
methods:{},
watch:{},
destroy(){},
}
</script>
<style scoped>

</style>
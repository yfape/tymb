<template>
	<q-footer bordered class="bg-white wl">
    	<q-tabs indicator-color="white" :ripple="false" v-model="tab" narrow-indicator dense class="text-grey" active-color="yellow-8">
	      <q-route-tab :disable="$store.state.loading" exact :name="1" to="/home">
	        <template v-slot:default>
	          <q-icon size="22px" :name="tab==1?'home':'o_home'"/>
	          <div class="text-caption">首页</div>
	        </template>
	      </q-route-tab>
	      <q-route-tab :disable="$store.state.loading" exact :name="2" to="/team">
	        <template v-slot:default>
	          <q-icon size="22px" :name="tab==2?'flag':'o_outlined_flag'"/>
	          <div class="text-caption">代表团</div>
	        </template>
	      </q-route-tab>
	      <q-route-tab :disable="$store.state.loading" exact :name="3" to="/records">
	        <template v-slot:default>
	          <q-icon size="22px" :name="tab==3?'date_range':'o_date_range'"/>
	          <div class="text-caption">记录</div>
	        </template>
	      </q-route-tab>
	      <q-route-tab :disable="$store.state.loading" exact :name="4" to="/user">
	        <template v-slot:default>
	          <q-icon size="22px" :name="tab==4?'face':'o_face'"/>
	          <div class="text-caption">我的</div>
	        </template>
	      </q-route-tab>
	    </q-tabs>
    </q-footer>
</template>
<script>
export default{
name:'footer1',
props:[],
components:{},
data(){return {
	tab:1
}},
mounted(){},
methods:{},
watch:{},
destroy(){},
}
</script>
<style scoped>

</style>
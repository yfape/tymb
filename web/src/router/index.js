import Vue from 'vue'
import VueRouter from 'vue-router'
import store from '@/store'
import wxauth from '@/views/wxauth'
import login from '@/views/login'
import portal from '../views/portal.vue'

import user from '@/views/user/user'
import auth from '@/views/user/auth'

import team from '@/views/team/team'
import createteam from '@/views/team/create'
import noteam from '@/views/team/noteam'
import teamlist from '@/views/team/teamlist'

import home from '@/views/home'
import program from '@/views/program/program'

import cards from '@/views/user/cards'
import records from '@/views/user/records'

import programs from '@/views/program/programs'
Vue.use(VueRouter)

const routes = [
	{ path: '/wxauth', name: 'wxauth', component: wxauth },
	{ path: '/login', name: 'login', component: login, props: (route) => ({ code: route.params.code })  },
  	{ path: '/', name: 'portal', component: portal,redirect:'/home',children:[
  		{ path: '/user', name: 'user', component: user },
  		{ path: '/auth', name: 'auth', component: auth },
  		{ path: '/cards', name: 'cards', component: cards },
  		{ path: '/records', name: 'records', component: records },
  		{ path: '/team', name: 'team', component: team },
  		{ path: '/noteam', name: 'noteam', component: noteam },
  		{ path: '/createteam', name: 'createteam', component: createteam },
  		{ path: '/teamlist', name: 'teamlist', component: teamlist },
  		{ path: '/home', name: 'home', component: home },
  		{ path: '/program/:pid', name: 'program', component: program, props:true },
  		{ path: '/programs/:sid', name: 'programs', component: programs, props:true },
  	]},
  	{ path:'*',redirect:'/' }
]

const router = new VueRouter({
  	routes
})


function checkToken(){
	// store.state.token = !store.state.token ? Vue.prototype.lStorage('token') : store.state.token
	// store.state.user = !store.state.user.openid ? Vue.prototype.lStorage('user') : store.state.user
	// store.state.userinfo = !store.state.userinfo ? Vue.prototype.lStorage('userinfo') : store.state.userinfo
	return (store.state.token && store.state.user) ? true : false
}

router.beforeEach((to, from, next) => {
	let code = Vue.prototype.getUrlKey('code')
	if(code){
		window.history.pushState(null,null,store.state.system.url)
		next({
			name:'login',
			params:{
				code:code
			}
		})
	}else{
		if(to.path == '/wxauth' || to.path == '/login'){
			next()
		}else if(!checkToken()){
			next('/wxauth')
		}else{
			next()
		}
	}
})

export default router

import Vue from 'vue'

import './styles/quasar.sass'
import iconSet from 'quasar/icon-set/material-icons-outlined.js'
import lang from 'quasar/lang/zh-hans.js'
import '@quasar/extras/material-icons/material-icons.css'
import '@quasar/extras/material-icons-outlined/material-icons-outlined.css'
import { Quasar,Notify,Loading,Dialog } from 'quasar'

Vue.use(Quasar, {
  config: {},
  components: { /* not needed if importStrategy is not 'manual' */ },
  directives: { /* not needed if importStrategy is not 'manual' */ },
  plugins: {Notify,Loading,Dialog
  },
  lang: lang,
  iconSet: iconSet
 })
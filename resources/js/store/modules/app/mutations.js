import { set, toggle } from '../../../utils/vuex'

export default {
  setDrawer: set('drawer'),
  setColor: set('color'),
  toggleDrawer: toggle('drawer')
}

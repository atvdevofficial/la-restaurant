import Scaffold from "../components/views/Scaffold.vue";
import Landing from "../components/views/Landing.vue";
import Signin from "../components/views/Signin.vue";
import Dashboard from "../components/views/Dashboard.vue";
import UserProfile from "../components/views/UserProfile.vue";
import TableList from "../components/views/TableList.vue";
import Typography from "../components/views/Typography.vue";
import Maps from "../components/views/Maps.vue";
import Icons from "../components/views/Icons.vue";
import Notifications from "../components/views/Notifications.vue";

// Pusher Component
import Pusher from '../components/views/Pusher.vue';

//Admin Routes
let adminRoutes = {
  path: "/admin",
  component: Scaffold,
  redirect: "/admin/dashboard",
  name: "Components",
  children: [
    { path: "dashboard", name: "Dashboard", components: { default: Dashboard }},
    { path: "user-profile", name: "UserProfile", components: { default: UserProfile }},
    { path: "table-list", name: "TableList", components: { default: TableList }},
    { path: "typography", name: "Typography", components: { default: Typography }},
    { path: "maps", name: "Maps", components: { default: Maps }},
    { path: "icons", name: "Icons", components: { default: Icons }},
    { path: "notifications", name: "Notifications", components: { default: Notifications }},
  ]
};

//Establishment Routes
let establishmentRoutes = {
    path: "/establishment",
    component: Scaffold,
    redirect: "/establishment/dashboard",
    name: "Components",
    children: [
      { path: "dashboard", name: "Dashboard", components: { default: Dashboard }},
      { path: "user-profile", name: "UserProfile", components: { default: UserProfile }},
      { path: "table-list", name: "TableList", components: { default: TableList }},
      { path: "typography", name: "Typography", components: { default: Typography }},
      { path: "maps", name: "Maps", components: { default: Maps }},
      { path: "icons", name: "Icons", components: { default: Icons }},
      { path: "notifications", name: "Notifications", components: { default: Notifications }},
    ]
  };

const routes = [
  {
    path: "/",
    name: "Landing",
    component: Landing,
  },
  {
    path: "/signin",
    name: "Signin",
    component: Signin,
  },
  adminRoutes,

  // Sample Route For Pusher
  {
      path: "/pusher",
      name: "Pusher",
      component: Pusher
  }
];

export default routes;

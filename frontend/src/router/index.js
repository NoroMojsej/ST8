import { createRouter, createWebHistory } from "vue-router";
import PresentationView from "../views/Presentation/HomeView.vue";
import EssayView from "../views/LandingPages/Essay/EssayView.vue";
import SignInBasicView from "../views/LandingPages/SignIn/signInView.vue";
import RegisterBasicView from "../views/LandingPages/Register/RegisterView.vue"
import GradeEssay from "../views/LandingPages/Reviewer/GradeEssay.vue";
import EditAccountView from "../layouts/sections/page-sections/page-headers/EditAccountView.vue";
import AdminHome from "../views/LandingPages/Admin/AdminHome.vue"
import ConferenceManager from "../views/LandingPages/Admin/ConferenceManager.vue"
import ConferenceAdd from "../views/LandingPages/Admin/ConferenceAdd.vue";
import ConferenceEdit from "../views/LandingPages/Admin/ConferenceEdit.vue"
import StudentHomeView from "../views/Student/StudentHomeView.vue";

import UserManagementView from "../layouts/sections/page-sections/page-headers/UserManagementView.vue";
import UsersListView from "../layouts/sections/page-sections/page-headers/UsersListView.vue";
import SectionManager from "../views/LandingPages/Admin/SectionManager.vue";
import UniversityManager from "../views/LandingPages/Admin/UniversityManager.vue";
import FacultyManager from "../views/LandingPages/Admin/FacultyManager.vue";
import DepartmentManager from "../views/LandingPages/Admin/DepartmentManager.vue";
import CreateUniversity from "../views/LandingPages/Admin/CreateUniversity.vue";
import EditUniversity from "../views/LandingPages/Admin/EditUniversity.vue";
import CreateFaculty from "../views/LandingPages/Admin/CreateFaculty.vue";
import EditFaculty from "../views/LandingPages/Admin/EditFaculty.vue";
import CreateDepartment from "../views/LandingPages/Admin/CreateDepartment.vue";
import EditDepartment from "../views/LandingPages/Admin/EditDepartment.vue";
import ConferenceEssays from "../views/LandingPages/Admin/ConferenceEssays.vue";
import ReviewEssayList from "../views/LandingPages/Reviewer/ReviewEssayList.vue";
import MyEssays from "../views/Student/MyEssays.vue";
import ConferenceList from "../views/Student/ConferenceList.vue";
const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "home",
      component: PresentationView,
    },
    {
      path: "/student/home/conference-list",
      name: "studentconference",
      component: ConferenceList,
    },
    {
      path: "/student/home/conference-list/essay-upload/:id",
      name: "essay",
      component: EssayView,
     },
     {
      path: "/pages/landing-pages/admin-control-panel",
      name: "adminhome",
      component: AdminHome,
     },
     {
      path: "/student/home",
      name: "student_home",
      component: StudentHomeView,
     },
     {
      path: "/student/home/my-essays",
      name: "myessays",
      component: MyEssays,
    },
     {
      path: "/reviewer/home",
      name: "reviewer_home",
      component: ReviewEssayList,
     },
     {
      path: "/pages/landing-pages/admin-control-panel/conference-manager",
      name: "conferenceman",
      component: ConferenceManager,
     },
     {
      path: "/pages/landing-pages/admin-control-panel/conference-manager/add-new",
      name: "conferenceadd",
      component: ConferenceAdd,
     },
     {
      path: "/pages/landing-pages/admin-control-panel/conference-manager/edit/:id",
      name: "conferenceedit",
      component: ConferenceEdit,
     },
     {
      path: "/pages/landing-pages/admin-control-panel/conference-manager/essays/:id",
      name: "conferenceessays",
      component: ConferenceEssays,
     },
     {
      path: "/pages/landing-pages/admin-control-panel/section-manager",
      name: "sectionman",
      component: SectionManager,
     },
     {
      path: "/pages/landing-pages/admin-control-panel/uni-manager",
      name: "universityman",
      component: UniversityManager,
     },
     {
      path: "/pages/landing-pages/admin-control-panel/uni-manager/add-new",
      name: "universityadd",
      component: CreateUniversity,
     },
     {
      path: "/pages/landing-pages/admin-control-panel/uni-manager/uni-edit/:id",
      name: "universityedit",
      component: EditUniversity,
     },
     {
      path: "/pages/landing-pages/admin-control-panel/faculty-manager/:id",
      name: "facultyman",
      component: FacultyManager,
     },
     {
      path: "/pages/landing-pages/admin-control-panel/faculty-manager/add-new",
      name: "facultyadd",
      component: CreateFaculty,
     },
     {
      path: "/pages/landing-pages/admin-control-panel/faculty-manager/fac-edit/:id",
      name: "facultyedit",
      component: EditFaculty,
     },
     {
      path: "/pages/landing-pages/admin-control-panel/department-manager/:id",
      name: "departmentman",
      component: DepartmentManager,
     },
     {
      path: "/pages/landing-pages/admin-control-panel/department-manager/add-new",
      name: "departmentadd",
      component: CreateDepartment,
     },
     {
      path: "/pages/landing-pages/admin-control-panel/department-manager/dep-edit/:id",
      name: "departmentedit",
      component: EditDepartment,
     },
     {
      path: "/pages/landing-pages/evaluation/:id",
      name: "evaluation",
      component: GradeEssay,
    },
    {
      path: "/pages/landing-pages/edit-account",
      name: "edit_account",
      component: EditAccountView,
    },
    {
      path: "/pages/landing-pages/admin-control-panel/users-list",
      name: "users_list",
      component: UsersListView,
    },
    {
      path: "/pages/landing-pages/admin-control-panel/users-list/:id",
      name: "user_management",
      component: UserManagementView,
    },
    {
      path: "/pages/landing-pages/sign-in",
      name: "signin-basic",
      component: SignInBasicView,
    },
    {
      path: "/pages/landing-pages/sign-up",
      name: "register-basic",
      component: RegisterBasicView,
    },
  ],
});

router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('auth_token');
  const isValid = localStorage.getItem('auth_valid') === 'true';

  if (to.meta.requiresAuth && (!token || !isValid)) {
    next({ name: 'home' }); // Redirect to login if session is invalid
  } else {
    next();
  }
});

export default router;

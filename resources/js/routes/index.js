import Vue from 'vue'
import Router  from 'vue-router'

// Components
import HomePage from '../pages/HomePage'

// Admin Components
import Admin from '../pages/Admin'
import Dashboard from '../pages/Admin/DashboardPage'
import Criteria from '../pages/Admin/CriteriaPage'
import Alternative from '../pages/Admin/AlternativePage'
// Analisis Components
import Analysis from '../pages/AnalysisPage'
import AnalysisCriteria from '../pages/AnalysisPage/AnalysisCriteriaPage'
import AnalysisCriteriaResult from '../pages/AnalysisPage/AnalysisCriteriaPage/Result'
import AnalysisAlternative from '../pages/AnalysisPage/AnalysisAlternativePage'
import AnalisisAlternativeResult from "../pages/AnalysisPage/AnalysisAlternativePage/Result";
import AnalysisResult from "../pages/AnalysisPage/AnalysisResult";

const router = new Router({
    mode: 'history',
    linkActiveClass: "active",
    linkExactActiveClass: "active",
    scrollBehavior (to, from) {
        return { x: 0, y: 0 }
    },
    routes: [
        { path: '/home', name: 'home', component: HomePage },
        { path: '/analysis', component: Analysis, children: [
            { path: 'criterias', name: 'analysis.criteria', component: AnalysisCriteria },
            { path: 'criteria/result', name: 'analysis.criteria.result', component: AnalysisCriteriaResult },
            { path: 'alternatives', name: 'analysis.alternative', component: AnalysisAlternative },
            { path: 'alternative/result/by-criteria-:criteriaId', name: 'analysis.alternative.byCriteria', component: AnalisisAlternativeResult },
            { path: 'result', name: 'analysis.result', component: AnalysisResult }
        ]},
        { path: '/admin', component: Admin, children: [
            { path: '', redirect: 'dashboard' },
            { path: 'dashboard', name: 'admin.dashboard', component: Dashboard },
            { path: 'criterias', name: 'admin.criterias', component: Criteria },
            { path: 'alternatives', name: 'admin.alternatives', component: Alternative },
        ]}
    ]
})

router.beforeResolve((to, from, next) => {
    if ($('.modal').hasClass('show')) {
        $('.modal').modal('hide');
    } else {
        $('body').removeClass('control-sidebar-slide-open');
        if (to.name) {
            // router.app.$Progress.start()
        }
        next()
    }
})


Vue.use(Router)

export default router;

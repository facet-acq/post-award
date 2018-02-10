// Vue Component
import FacetLandingPage  from './components/FacetLandingPage';
import Temp from './components/Temp';

export default [
  {
    path: '/',
    name: 'home',
    component: FacetLandingPage
  },
  {
    path: '/temp',
    name: 'temp',
    component: Temp
  }
];

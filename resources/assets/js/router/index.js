import Vue from 'vue'
import Router from 'vue-router'
import { store } from '../store'

Vue.use(Router)

export const constantRouterMap = [
  {
    path: '/',
    name: 'Dashboard',
    meta: {
      title: 'Статистика',
      subtitle: 'Здесь вы найдёте ваши последние статистические данные'
    },
    component: () => import('@/views/dashboard/index')
  },
  {
    path: '/history',
    name: 'History',
    meta: {
      title: 'История операций',
      subtitle: 'Здесь вы можете найти историю платежей'
    },
    component: () => import('@/views/dashboard/history')
  },
  {
    path: '/profile',
    name: 'Profile',
    meta: {
      title: 'Профиль',
      subtitle: 'Здесь вы можете изменять настройки своей учётной записи'
    },
    component: () => import('@/views/user/profile')
  },
  {
    path: '/payment',
    name: 'Payment',
    meta: {
      title: 'Оплата',
      subtitle: 'Чтобы пройти тесты вам нужно оплатить подписку'
    },
    component: () => import('@/views/dashboard/payment')
  },
  {
    path: '/pay/:id',
    name: 'Pay',
    meta: {
      title: 'Оплата',
      subtitle: 'Чтобы пройти тесты вам нужно оплатить подписку'
    },
    component: () => import('@/views/dashboard/pay')
  },
  {
    path: '/thematic',
    name: 'Thematic',
    meta: {
      title: 'Тематический тест',
      subtitle: 'Пройти тест по выбранному направлению'
    },
    component: () => import('@/views/test/thematic')
  },
  {
    path: '/thematic/:id',
    name: 'Thematic Test',
    meta: {
      title: 'Тематический тест',
      subtitle: 'Пройти тест по выбранному направлению'
    },
    component: () => import('@/views/test/demo'),
    props: { 
      type: 'thematic'
    }
  },
  {
    path: '/mistakes/:id',
    name: 'WorkingOnMistakes',
    meta: {
      title: 'Работа над ошибками',
      subtitle: 'Сверьте ваши ответы с верными'
    },
    component: () => import('@/views/test/mistakes')
  },
  {
  	path: '/demo/:sub1/:sub2/:sub3',
    name: 'Demo',
    meta: {
      title: 'Тест по направлению',
      subtitle: 'Пройти тест по выбранному направлению'
    },
    component: () => import('@/views/test/demo'),
    props: { 
      type: 'demo'
    }
  },
  {
  	path: '/direction/:sub1/:sub2/:sub3',
    name: 'Direction',
    meta: {
      title: 'Тест по направлению',
      subtitle: 'Пройти тест по выбранному направлению'
    },
    component: () => import('@/views/test/demo'),
    props: { 
      type: 'direction'
    }
  },
  {
    path: '/tickets',
    name: 'Tickets',
    meta: {
      title: 'Тикеты',
      subtitle: 'Задайте вопрос, который вас интересует'
    },
    component: () => import('@/views/ticket/list')
  },
  {
    path: '/tickets/:id',
    name: 'TicketInner',
    meta: {
      title: 'Тикеты',
      subtitle: 'Задайте вопрос, который вас интересует'
    },
    component: () => import('@/views/ticket/messages')
  },
  {
    path: '/demo-select',
    redirect: to => {
      const user = store.getters.user
      return '/demo/'+ user.subject_1_id +'/' + user.subject_2_id + '/' + user.subject_3_id
    }
  },
  {
    path: '/direction-select',
    redirect: to => {
      const user = store.getters.user
      return '/direction/'+ user.subject_1_id +'/' + user.subject_2_id + '/' + user.subject_3_id
    }
  }
]

export default new Router({
  routes: constantRouterMap
})
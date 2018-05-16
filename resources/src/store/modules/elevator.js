import * as states from './elevatorStates'
import Vue from 'vue'

const state = {
  strategy: false,
  doorsOpened: false,
  direction: null,
  currentFloor: 1,
  targetFloor: null,
  personsInside: 0,
  numberOfFloors: 0,
  calls: [],
  ajax: null
};

// getters
const getters = {

};

// actions
const actions = {
  requestStateResolution({commit}) {
    Vue.http.post('elevator/', state, {
      before(request) {
        // abort previous request, if exists
        if (Vue.previousRequest) {
          Vue.previousRequest.abort();
        }
        // set previous request on Vue instance
        Vue.previousRequest = request;
      }
    }).then(response => {
      commit('setTargetFloor', {
        targetFloor: response.body.targetFloor
      });
      commit('setDirection', {
        direction: response.body.direction
      })
    }, response => {
      console.log('error', response);
    })
  },
  reset({commit}, settings) {
    commit(states.INIT, settings)
  },
  addCall({dispatch, commit}, elevatorCall) {
    commit('addCall', {
      direction: elevatorCall.direction,
      from: elevatorCall.fromFloor ? elevatorCall.fromFloor : null,
      to: elevatorCall.toFloor ? elevatorCall.toFloor : null
    });

    if (state.doorsOpened) {
      return;
    }

    dispatch('requestStateResolution');
  },
  openDoors({commit, dispatch}) {
    commit('openDoors');
    setTimeout(function closeDoors() {
      if (state.personsInside > 0 && state.calls.length === 0) {
        setTimeout(closeDoors, 4000);
        return;
      }

      commit('closeDoors');
      if (state.calls.length) {
        dispatch('requestStateResolution')
      }
    }, 4000);
  },
  setCurrentFloor({commit}, payload) {
    commit('setCurrentFloor', payload)
  },
  getInCabin({commit}) {
    commit('getInCabin');
  },
  getOutCabin({commit}) {
    commit('getOutCabin');
  }
};

// mutations
const mutations = {
  init (state, payload) {
    state.strategy = payload.strategy ? payload.strategy : false;
    state.numberOfFloors = payload.numberOfFloors ? payload.numberOfFloors : 5;
    state.calls = [];
    state.doorsOpened = false;
    state.personsInside = 0;
    state.currentFloor = 1;
    state.targetFloor = null;
    state.direction = null;
  },
  addCall(state, payload) {
    state.calls.push(payload);
  },
  openDoors(state) {
    state.doorsOpened = true;
    state.calls = state.calls.filter(function (call) {
      return !(call.to === state.currentFloor || call.from === state.currentFloor)
    });

    state.targetFloor = null;
  },
  closeDoors(state) {
    state.doorsOpened = false;
  },
  setCurrentFloor(state, payload) {
    state.currentFloor = payload.currentFloor
  },
  setDirection(state, payload) {
    state.direction = payload.direction
  },
  getInCabin(state) {
    state.personsInside++;
  },
  getOutCabin(state) {
    state.personsInside--;
  },
  setTargetFloor(state, payload) {
    state.targetFloor = payload.targetFloor;
  }
};

export default {
  state,
  getters,
  actions,
  mutations
}
import * as states from './elevatorStates'
// initial state
// shape: [{ id, quantity }]
const state = {
  doorsOpened: false,
  height: 0,
  direction: null,
  currentFloor: 1,
  targetFloor: null,
  personsInside: 0,
  numberFloors: 0,
  elevatorCalls: []
};

// getters
const getters = {
  floorHeight: state => {
    console.log('el', state)
    return Math.ceil(state.height / state.numberFloors);
  }
};

// actions
const actions = {
  reset({commit}, settings) {
    commit(states.INIT, settings)
  },
  addCall({commit}, elevatorCall) {
    commit('addCall', {
      direction: elevatorCall.direction,
      from: elevatorCall.fromFloor ? elevatorCall.fromFloor : null,
      to: elevatorCall.toFloor ? elevatorCall.toFloor : null
    })
  }
};

// mutations
const mutations = {
  init (state, payload) {
    state.height = payload.height ? payload.height : 1000;
    state.numberFloors = payload.numberFloors ? payload.numberFloors : 5;
    state.elevatorCalls = [];
    state.doorsOpened = false;
    state.personsInside = 0;
    state.currentFloor = 1;
    state.targetFloor = null;
    state.direction = null;
  },
  addCall(state, payload) {
    state.elevatorCalls.push(payload);
  },
  openDoors(state, payload) {

    state.doorsOpened = true;
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
import Vue from 'vue'
import { install } from 'vue2-google-maps'

import { mount } from '@vue/test-utils'
import MapComponent from '../components/MapComponent';

beforeEach(() => {
    install(Vue, {load: {key: process.env.MIX_GOOGLE_MAPS_API_KEY}});
});

describe('It can load the map component', () => {
    test('It can render the map container', () => {
        const wrapper = mount(MapComponent);
        expect(wrapper.find('.vue-map-container').exists()).toBe(true);
    })
})

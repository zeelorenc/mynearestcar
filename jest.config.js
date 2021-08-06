module.exports = {
    "moduleFileExtensions": [
        "js",
        "json",
        "vue"
    ],
    "transform": {
        ".*\\.(vue)$": "vue-jest",
        ".*\\.(js)$": "babel-jest"
    },
    "transformIgnorePatterns": [
        "node_modules/(?!vue2-google-maps)"
    ],
    "testEnvironment": "jsdom"
};

import axios from "axios";

const APP_URL = "/api/auth"

const register = async (userData) => {
    try {
        const response = await axios.post(`${APP_URL}/register`, userData)

        return response.data

    } catch (error) {
        throw error.response?.data || error.message
    }
}

const login = async (credentials) => {
    try {
        const response = await axios.post(`${APP_URL}/login`, credentials)

        return response.data
    }
    catch (error) {
        throw error.response?.data || error.message
    }
}

const logout = async () => {
    try {

        const token = localStorage.getItem('auth_token')

        const response = await axios.post(`${APP_URL}/logout`, null, {
            headers: {
                "Authorization": `Bearer ${token}`
            }
        })

        return response.data
    }
    catch (error) {
        throw error.response?.data || error.message
    }
}

const getUser = async () => {
    try {

        const token = localStorage.getItem('auth_token')

        if (!token) {
            return null
        }

        const response = await axios.get(`${APP_URL}/user`, {
            headers: {
                "Authorization": `Bearer ${token}`
            }
        })

        return response.data
    }
    catch (error) {
        throw error.response?.data || error.message
    }
}

export default {
    register,
    login,
    logout,
    getUser,
}
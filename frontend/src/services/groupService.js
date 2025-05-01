import axios from "axios";

const APP_URL = "/api/groups"

const getUserGroups = async () => {

    try {
        const token = localStorage.getItem('auth_token')

        const response = await axios.get(`${APP_URL}/`, {
            headers: {
                "Authorization": `Bearer ${token}`
            }
        })

        return response.data

    } catch (error) {
        throw error.response?.data || error.message
    }
}

const getGroupMessages = async (groupId) => {
    try {
        const token = localStorage.getItem('auth_token')

        const response = await axios.get(`${APP_URL}/${groupId}/messages`, {
            headers: {
                "Authorization": `Bearer ${token}`
            }
        })

        return response?.data
    }
    catch (error) {
        throw error.response?.data || error.message
    }
}

const sendMessage = async (groupId, message) => {
    try {
        const token = localStorage.getItem('auth_token')

        const response = await axios.post(`${APP_URL}/${groupId}/messages`, {
            message
        }, {
            headers: {
                "Authorization": `Bearer ${token}`
            }
        })

        return response?.data
    }
    catch (error) {
        throw error.response?.data || error.message
    }
}


export default {
    getUserGroups,
    getGroupMessages,
    sendMessage,
}
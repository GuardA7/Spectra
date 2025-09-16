<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50 p-4">
    <div class="w-full max-w-md bg-white rounded-xl shadow-md overflow-hidden">

      <!-- Header -->
      <div class="bg-gradient-to-r from-green-600 to-indigo-700 text-white p-6 text-center">
        <h2 class="text-2xl font-bold">Reset Kata Sandi</h2>
        <p class="text-sm opacity-90">Masukkan password baru</p>
      </div>

      <div class="p-6">
        <!-- Notifikasi -->
        <div v-if="statusMessage" 
             :class="statusType === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'" 
             class="p-2 rounded mb-4 text-sm">
          {{ statusMessage }}
        </div>

        <form @submit.prevent="submit" class="space-y-4">
          <!-- Email (readonly) -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" v-model="form.email" readonly 
                   class="w-full px-3 py-2 border rounded bg-gray-50 cursor-not-allowed" />
          </div>

          <!-- Password Baru -->
          <div class="relative">
            <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
            <input :type="showPassword ? 'text' : 'password'" v-model="form.password" placeholder="Password baru" 
                   class="w-full px-3 py-2 border rounded pr-10" />
            <button type="button" @click="showPassword = !showPassword" 
                    class="absolute right-2 top-11 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
              <svg v-if="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7
                         -1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
              </svg>
              <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7
                         a10.053 10.053 0 012.507-4.257m3.37-2.35a9.978 9.978 0 014.666-1.393
                         M15 12a3 3 0 11-6 0 3 3 0 016 0zM3 3l18 18" />
              </svg>
            </button>
          </div>

          <!-- Konfirmasi Password -->
          <div class="relative">
            <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
            <input :type="showConfirmPassword ? 'text' : 'password'" 
                   v-model="form.password_confirmation" placeholder="Konfirmasi password" 
                   class="w-full px-3 py-2 border rounded pr-10" />
            <button type="button" @click="showConfirmPassword = !showConfirmPassword" 
                    class="absolute right-2 top-11 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
              <svg v-if="!showConfirmPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7
                         -1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
              </svg>
              <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7
                         a10.053 10.053 0 012.507-4.257m3.37-2.35a9.978 9.978 0 014.666-1.393
                         M15 12a3 3 0 11-6 0 3 3 0 016 0zM3 3l18 18" />
              </svg>
            </button>
          </div>

          <!-- Submit -->
          <button type="submit" :disabled="isLoading" 
                  class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 transition">
            {{ isLoading ? 'Memproses...' : 'Reset Password' }}
          </button>
        </form>

        <div class="mt-4 text-center">
          <Link href="/login" class="text-green-600 text-sm hover:underline">Kembali ke login</Link>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { reactive, ref, onMounted } from 'vue'
import { Link } from '@inertiajs/vue3'
import axios from 'axios'

const tokenFromQuery = new URLSearchParams(window.location.search).get('token') || ''
const emailFromQuery = new URLSearchParams(window.location.search).get('email') || ''

const form = reactive({
  token: tokenFromQuery,
  email: emailFromQuery,
  password: '',
  password_confirmation: ''
})

const errors = reactive({})
const isLoading = ref(false)
const statusMessage = ref('')
const statusType = ref('success') // success / error

const showPassword = ref(false)
const showConfirmPassword = ref(false)

const submit = async () => {
  Object.keys(errors).forEach(k => delete errors[k])
  statusMessage.value = ''
  statusType.value = 'success'

  let hasError = false
  if (!form.password) { errors.password = 'Password wajib diisi'; hasError = true }
  else if (form.password.length < 8) { errors.password = 'Password minimal 8 karakter'; hasError = true }

  if (!form.password_confirmation) { errors.password_confirmation = 'Konfirmasi wajib diisi'; hasError = true }
  else if (form.password !== form.password_confirmation) { errors.password_confirmation = 'Password tidak cocok'; hasError = true }

  if (hasError) return

  isLoading.value = true
  try {
    const res = await axios.post('/reset-password', form)
    statusMessage.value = res.data.success
    statusType.value = 'success'
    form.password = ''
    form.password_confirmation = ''
  } catch (err) {
    if (err.response && err.response.data) {
      const data = err.response.data
      statusMessage.value = data.error || 'Terjadi kesalahan'
      statusType.value = 'error'
      if (data.errors) Object.assign(errors, data.errors)
    } else {
      statusMessage.value = 'Terjadi kesalahan server'
      statusType.value = 'error'
    }
  } finally {
    isLoading.value = false
  }
}

onMounted(() => {
  if (!form.token || !form.email) {
    alert('Token atau email tidak valid. Silakan minta link reset password kembali.')
    window.location.href = '/forgot-password'
  }
})
</script>
<template>
  <InvestorLayout :user="user" :profileUrl="profileUrl" :logoutUrl="logoutUrl">
    <div class="flex flex-col space-y-6 w-full">

      <!-- Header dengan Total Dompet -->
      <div class="bg-gradient-to-r from-blue-600 to-green-600 rounded-2xl p-6 text-white shadow-xl">
        <h2 class="text-lg font-semibold opacity-90">TOTAL DOMPET</h2>
        <p class="text-4xl font-bold mt-2">{{ currency }} {{ formatNumber(walletBalance) }}</p>
        <p class="mt-2 text-blue-100 flex items-center">
          <svg class="w-4 h-4 mr-2 fill-current" viewBox="0 0 448 512">
            <path d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z"/>
          </svg>
          {{ user.name }}
          <span v-if="user.affiliate_id" class="ml-3 bg-yellow-500 text-white text-xs px-2 py-1 rounded-full">Konsultan</span>
        </p>
      </div>

      <!-- Menu Navigasi -->
      <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
        <button @click="navigateTo('/deposit')" class="bg-white rounded-xl shadow-md p-4 flex flex-col items-center justify-center hover:bg-blue-50 transition-colors">
          <svg class="w-6 h-6 text-blue-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
          <span class="text-sm font-medium">Deposit</span>
        </button>
        
        <button @click="navigateTo('/dompet')" class="bg-white rounded-xl shadow-md p-4 flex flex-col items-center justify-center hover:bg-blue-50 transition-colors">
          <svg class="w-6 h-6 text-green-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
          </svg>
          <span class="text-sm font-medium">Withdraw</span>
        </button>
        
        <button @click="navigateTo('/karir')" class="bg-white rounded-xl shadow-md p-4 flex flex-col items-center justify-center hover:bg-blue-50 transition-colors">
          <svg class="w-6 h-6 text-purple-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
          </svg>
          <span class="text-sm font-medium">Afiliasi</span>
        </button>
        
        <button @click="navigateTo('/dompet')" class="bg-white rounded-xl shadow-md p-4 flex flex-col items-center justify-center hover:bg-blue-50 transition-colors">
          <svg class="w-6 h-6 text-gray-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
          <span class="text-sm font-medium">Riwayat</span>
        </button>
      </div>

      <!-- Statistik Keuangan - DITAMBAHKAN 2 KARTU BARU -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white rounded-2xl shadow-md p-5">
          <div class="flex justify-between items-center">
            <h3 class="text-gray-500 font-medium">Saldo Deposit</h3>
            <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">Aktif</span>
          </div>
          <p class="text-2xl font-bold text-gray-800 mt-2">{{ currency }} {{ formatNumber(depositBalance) }}</p>
          <div class="mt-3 text-sm text-gray-500">
            <div class="flex justify-between">
              <span>Paket Aktif:</span>
              <span class="font-medium">{{ activePackages.length }}</span>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-2xl shadow-md p-5">
          <div class="flex justify-between items-center">
            <h3 class="text-gray-500 font-medium">Total Keuntungan</h3>
            <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Profit</span>
          </div>
          <p class="text-2xl font-bold text-gray-800 mt-2">{{ currency }} {{ formatNumber(totalProfit) }}</p>
          <div class="mt-3 text-sm text-gray-500">
            <div class="flex justify-between">
              <span>Estimasi Profit/Bulan:</span>
              <span class="font-medium">{{ currency }} {{ formatNumber(estimatedMonthlyProfit) }}</span>
            </div>
          </div>
        </div>

        <!-- Kartu Baru: Total Komisi Afiliasi -->
        <div class="bg-white rounded-2xl shadow-md p-5">
          <div class="flex justify-between items-center">
            <h3 class="text-gray-500 font-medium">Total Komisi Afiliasi</h3>
            <span class="bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded-full">Komisi</span>
          </div>
          <p class="text-2xl font-bold text-gray-800 mt-2">{{ currency }} {{ formatNumber(totalAffiliateCommission) }}</p>
          <div class="mt-3 text-sm text-gray-500">
            <div class="flex justify-between">
              <span>Sponsor:</span>
              <span class="font-medium">{{ currency }} {{ formatNumber(affiliateData.sponsorCommission) }}</span>
            </div>
            <div class="flex justify-between">
              <span>Profit Sharing:</span>
              <span class="font-medium">{{ currency }} {{ formatNumber(affiliateData.profitSharing) }}</span>
            </div>
          </div>
        </div>

        <!-- Kartu Baru: Komisi Extra -->
        <div class="bg-white rounded-2xl shadow-md p-5">
          <div class="flex justify-between items-center">
            <h3 class="text-gray-500 font-medium">Komisi Extra</h3>
            <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full">Bonus</span>
          </div>
          <p class="text-2xl font-bold text-gray-800 mt-2">{{ currency }} {{ formatNumber(extraCommission) }}</p>
          <div class="mt-3 text-sm text-gray-500">
            <div class="flex justify-between">
              <span>Status:</span>
              <span :class="[hasExtraBonus ? 'text-green-600' : 'text-gray-600', 'font-medium']">
                {{ hasExtraBonus ? 'Aktif' : 'Tidak Aktif' }}
              </span>
            </div>
            <div class="flex justify-between">
              <span>Target:</span>
              <span class="font-medium">{{ currency }} {{ formatNumber(10000) }}</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Informasi Kontrak Investasi -->
      <div class="bg-white rounded-2xl shadow-md p-5">
        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
          <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
          </svg>
          Kontrak Investasi Aktif
        </h3>
        
        <div v-if="activePackages.length > 0" class="space-y-4">
          <div v-for="pkg in activePackages" :key="pkg.id" class="border border-gray-200 rounded-lg p-4">
            <div class="flex justify-between items-start">
              <div>
                <h4 class="font-medium text-gray-800">Paket {{ pkg.package_name }}</h4>
                <p class="text-sm text-gray-600">Nilai: {{ currency }} {{ formatNumber(pkg.amount) }}</p>
              </div>
              <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Aktif</span>
            </div>
            
            <div class="mt-3 grid grid-cols-2 gap-2 text-sm">
              <div>
                <p class="text-gray-500">Mulai</p>
                <p class="font-medium">{{ formatDate(pkg.start_date) }}</p>
              </div>
              <div>
                <p class="text-gray-500">Berakhir</p>
                <p class="font-medium">{{ formatDate(pkg.end_date) }}</p>
              </div>
            </div>
            
            <div class="mt-3">
              <div class="flex justify-between text-sm mb-1">
                <span class="text-gray-500">Progress</span>
                <span class="font-medium">{{ pkg.progress }}%</span>
              </div>
              <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-blue-600 h-2 rounded-full" :style="{ width: pkg.progress + '%' }"></div>
              </div>
            </div>
          </div>
        </div>
        
        <div v-else class="text-center py-8 text-gray-500">
          <svg class="w-16 h-16 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-16M9 7h6m-6 4h6m-6 4h6"></path>
          </svg>
          <p>Belum ada paket investasi aktif</p>
          <button @click="navigateTo('/deposit')" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">
            Deposit Sekarang
          </button>
        </div>
      </div>

      <!-- Informasi Afiliasi (jika konsultan) -->
      <div v-if="user.affiliate_id" class="bg-white rounded-2xl shadow-md p-5">
        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
          <svg class="w-5 h-5 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
          </svg>
          Informasi Afiliasi
        </h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="bg-purple-50 rounded-lg p-4">
            <h4 class="text-sm font-medium text-purple-800">Komisi Sponsor</h4>
            <p class="text-2xl font-bold text-purple-900 mt-1">{{ currency }} {{ formatNumber(affiliateData.sponsorCommission) }}</p>
            <div class="mt-2 text-xs text-purple-700">
              <div class="flex justify-between">
                <span>Level 1 (7.5%):</span>
                <span>{{ currency }} {{ formatNumber(affiliateData.sponsorLevel1) }}</span>
              </div>
              <div class="flex justify-between">
                <span>Level 2 (2.5%):</span>
                <span>{{ currency }} {{ formatNumber(affiliateData.sponsorLevel2) }}</span>
              </div>
            </div>
          </div>
          
          <div class="bg-green-50 rounded-lg p-4">
            <h4 class="text-sm font-medium text-green-800">Profit Sharing</h4>
            <p class="text-2xl font-bold text-green-900 mt-1">{{ currency }} {{ formatNumber(affiliateData.profitSharing) }}</p>
            <div class="mt-2 text-xs text-green-700">
              <div class="flex justify-between">
                <span>Level 1 (1.25%):</span>
                <span>{{ currency }} {{ formatNumber(affiliateData.profitLevel1) }}</span>
              </div>
              <div class="flex justify-between">
                <span>Level 2 (0.75%):</span>
                <span>{{ currency }} {{ formatNumber(affiliateData.profitLevel2) }}</span>
              </div>
              <div class="flex justify-between">
                <span>Level 3 (0.5%):</span>
                <span>{{ currency }} {{ formatNumber(affiliateData.profitLevel3) }}</span>
              </div>
            </div>
          </div>
        </div>
        
        <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
          <div class="bg-gray-50 rounded-lg p-3">
            <p class="text-2xl font-bold text-gray-800">{{ affiliateData.referralCount.level1 }}</p>
            <p class="text-xs text-gray-600">Referral Level 1</p>
          </div>
          <div class="bg-gray-50 rounded-lg p-3">
            <p class="text-2xl font-bold text-gray-800">{{ affiliateData.referralCount.level2 }}</p>
            <p class="text-xs text-gray-600">Referral Level 2</p>
          </div>
          <div class="bg-gray-50 rounded-lg p-3">
            <p class="text-2xl font-bold text-gray-800">{{ currency }} {{ formatNumber(affiliateData.directTurnover) }}</p>
            <p class="text-xs text-gray-600">Omset Direct</p>
          </div>
        </div>
        
        <!-- Bonus Extra Status -->
        <div v-if="affiliateData.directTurnover >= 10000" class="mt-4 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
          <div class="flex items-center">
            <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
            </svg>
            <h4 class="font-medium text-yellow-800">Bonus Extra Aktif!</h4>
          </div>
          <p class="text-sm text-yellow-700 mt-1">Anda mendapatkan tambahan 1.25% profit sharing di level 1</p>
        </div>
        <div v-else class="mt-4 bg-blue-50 border border-blue-200 rounded-lg p-4">
          <div class="flex items-center">
            <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
            <h4 class="font-medium text-blue-800">Target Bonus Extra</h4>
          </div>
          <p class="text-sm text-blue-700 mt-1">Butuh {{ currency }} {{ formatNumber(10000 - affiliateData.directTurnover) }} lagi untuk mendapatkan bonus extra</p>
          <div class="mt-2 w-full bg-gray-200 rounded-full h-2">
            <div class="bg-blue-600 h-2 rounded-full" :style="{ width: Math.min((affiliateData.directTurnover / 10000) * 100, 100) + '%' }"></div>
          </div>
        </div>
      </div>

      <!-- Slider Pengumuman Aktif -->
      <section class="p-1 container mx-auto">
        <div class="rounded-3xl overflow-hidden">
          <div class="bg-gradient-to-r from-blue-600 to-green-500 p-4 flex justify-center items-center text-white">
            <h3 class="text-2xl font-bold flex items-center space-x-2">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
              </svg>
              <span>Pengumuman</span>
            </h3>
          </div>

          <div class="mt-4 w-full">
            <swiper v-if="announcements.length"
                    :modules="[Navigation, Pagination, Autoplay]"
                    :slides-per-view="1"
                    :loop="true"
                    :autoplay="{ delay: 4000 }"
                    pagination
                    navigation
                    class="w-full max-w-[100%] mx-auto rounded-3xl shadow-lg aspect-[7/2]">
              <swiper-slide v-for="a in announcements" :key="a.id" class="flex justify-center items-center">
                <img :src="a.image_url" :alt="a.title" class="w-full h-full object-cover rounded-3xl" />
              </swiper-slide>
            </swiper>
            <p v-else class="text-gray-600 text-center text-lg font-medium mt-10">
              Belum ada pengumuman aktif.
            </p>
          </div>
        </div>
      </section>

    </div>
  </InvestorLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Navigation, Pagination, Autoplay } from 'swiper/modules';
import InvestorLayout from '@/Layouts/InvestorLayout.vue';
import axios from 'axios'

const { props } = usePage();
const user = props.auth?.user || {};
const walletBalance = ref(props.walletBalance ?? 0);
const depositBalance = ref(props.depositBalance ?? 0);
const totalProfit = ref(props.totalProfit ?? 0);
const announcements = ref(props.announcements ?? []);
const profileUrl = props.profileUrl ?? '/profile';
const logoutUrl = props.logoutUrl ?? '/logout';
const activePackages = ref(props.activePackages ?? []);
const affiliateData = ref(props.affiliateData ?? {
  sponsorCommission: 0,
  sponsorLevel1: 0,
  sponsorLevel2: 0,
  profitSharing: 0,
  profitLevel1: 0,
  profitLevel2: 0,
  profitLevel3: 0,
  referralCount: {
    level1: 0,
    level2: 0
  },
  directTurnover: 0
});

// Softcode currency dari preferensi user
const currency = props.user_preferences?.currency ?? 'USDT';

// Hitung estimasi profit bulanan
const estimatedMonthlyProfit = computed(() => {
  return activePackages.value.reduce((total, pkg) => {
    return total + (pkg.amount * 0.075); // 7.5% per bulan
  }, 0);
});

// Hitung total komisi afiliasi (sponsor + profit sharing)
const totalAffiliateCommission = computed(() => {
  return (affiliateData.value.sponsorCommission || 0) + (affiliateData.value.profitSharing || 0);
});

// Hitung komisi extra (jika ada)
const extraCommission = computed(() => {
  // Asumsi komisi extra adalah 1.25% dari omset direct jika mencapai target
  if (affiliateData.value.directTurnover >= 10000) {
    return affiliateData.value.directTurnover * 0.0125;
  }
  return 0;
});

// Status bonus extra
const hasExtraBonus = computed(() => {
  return affiliateData.value.directTurnover >= 10000;
});

// Fungsi untuk format angka
const formatNumber = (value) => {
  return new Intl.NumberFormat('id-ID').format(value);
};

// Fungsi untuk format tanggal
const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString('id-ID', {
    day: 'numeric',
    month: 'short',
    year: 'numeric'
  });
};

// Fungsi navigasi
const navigateTo = (path) => {
  router.visit(path);
};

async function fetchDashboardData() {
  try {
    const res = await axios.get('/investor/dashboard-data');
    walletBalance.value = res.data.walletBalance;
    depositBalance.value = res.data.depositBalance;
    totalProfit.value = res.data.totalProfit;
    activePackages.value = res.data.activePackages;
    
    if (res.data.affiliateData) {
      affiliateData.value = res.data.affiliateData;
    }
  } catch (error) {
    console.error('Gagal fetch dashboard data:', error);
  }
}

onMounted(() => {
  // Jika data tidak lengkap, fetch dari API
  if (activePackages.value.length === 0 || !affiliateData.value) {
    fetchDashboardData();
  }
});
</script>

<style scoped>
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css');

.swiper-button-prev,
.swiper-button-next {
  top: 50%;
  transform: translateY(-50%);
  z-index: 20;
  width: 2rem;
  height: 2rem;
  color: white;
  background: rgba(0,0,0,0.3);
  border-radius: 9999px;
}

.swiper-button-prev { left: 0.5rem; }
.swiper-button-next { right: 0.5rem; }

.swiper-pagination {
  bottom: 0.5rem !important;
}

.swiper-slide img {
  transition: transform 0.5s ease-in-out;
}

@media (max-width: 640px) {
  .swiper-slide { height: 20rem; }
}
@media (min-width: 641px) and (max-width: 1024px) {
  .swiper-slide { height: 24rem; }
}
@media (min-width: 1025px) {
  .swiper-slide { height: 32rem; }
}
</style>
<script setup lang="ts">
import { ref, computed, watch } from 'vue'
import { router } from '@inertiajs/vue3'
import Table from './Table.vue'
import TableHeader from './TableHeader.vue'
import TableBody from './TableBody.vue'
import TableRow from './TableRow.vue'
import TableHead from './TableHead.vue'
import TableCell from './TableCell.vue'

interface Column {
  key: string
  label: string
  sortable?: boolean
  align?: 'left' | 'center' | 'right'
  width?: string
  render?: (value: any, row: any) => string
}

interface PaginationData {
  current_page: number
  last_page: number
  per_page: number
  total: number
  from: number
  to: number
}

const props = defineProps<{
  data: any[]
  columns: Column[]
  loading?: boolean
  selectable?: boolean
  clickable?: boolean
  pagination?: PaginationData
  sortBy?: string
  sortDirection?: 'asc' | 'desc'
  searchable?: boolean
  emptyMessage?: string
  class?: string
}>()

const emit = defineEmits<{
  (e: 'row-click', row: any): void
  (e: 'selection-change', selected: any[]): void
  (e: 'sort', column: string, direction: 'asc' | 'desc'): void
}>()

const selectedRows = ref<Set<any>>(new Set())
const searchQuery = ref('')
const isAllSelected = ref(false)

const filteredData = computed(() => {
  if (!props.searchable || !searchQuery.value) {
    return props.data
  }

  return props.data.filter(row =>
    Object.values(row).some(value =>
      String(value).toLowerCase().includes(searchQuery.value.toLowerCase())
    )
  )
})

const handleSort = (column: Column) => {
  if (!column.sortable) return

  const newDirection = props.sortBy === column.key && props.sortDirection === 'asc' ? 'desc' : 'asc'
  emit('sort', column.key, newDirection)
}

const handleRowClick = (row: any) => {
  if (props.clickable) {
    emit('row-click', row)
  }
}

const toggleRowSelection = (row: any) => {
  if (selectedRows.value.has(row)) {
    selectedRows.value.delete(row)
  } else {
    selectedRows.value.add(row)
  }
  emit('selection-change', Array.from(selectedRows.value))
}

const toggleAllSelection = () => {
  if (isAllSelected.value) {
    selectedRows.value.clear()
  } else {
    filteredData.value.forEach(row => selectedRows.value.add(row))
  }
  isAllSelected.value = !isAllSelected.value
  emit('selection-change', Array.from(selectedRows.value))
}

const getCellValue = (row: any, column: Column) => {
  const value = row[column.key]
  return column.render ? column.render(value, row) : value
}

const goToPage = (page: number) => {
  router.get(window.location.pathname, { page }, { preserveState: true })
}

watch(selectedRows, (newSelection) => {
  isAllSelected.value = newSelection.size === filteredData.value.length && filteredData.value.length > 0
}, { deep: true })
</script>

<template>
  <div :class="['space-y-4', props.class]">
    <!-- Search Bar -->
    <div v-if="searchable" class="flex items-center space-x-2">
      <div class="relative flex-1 w-full max-w-8xl">
        <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
        <input
          v-model="searchQuery"
          type="text"
          placeholder="Ara..."
          class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
        />
      </div>
    </div>

    <!-- Table Container -->
    <div class="bg-white dark:bg-gray-950 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
      <!-- Loading Overlay -->
      <div v-if="loading" class="relative">
        <div class="absolute inset-0 bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm flex items-center justify-center z-10">
          <div class="flex items-center space-x-2">
            <div class="w-5 h-5 border-2 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Yükleniyor...</span>
          </div>
        </div>
      </div>

      <Table>
        <TableHeader>
          <TableRow>
            <!-- Selection Column -->
            <TableHead v-if="selectable" class="w-12">
              <input
                type="checkbox"
                :checked="isAllSelected"
                @change="toggleAllSelection"
                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
              />
            </TableHead>

            <!-- Data Columns -->
            <TableHead
              v-for="column in columns"
              :key="column.key"
              :sortable="column.sortable"
              :sort-direction="sortBy === column.key ? sortDirection : null"
              :class="column.width ? `w-${column.width}` : ''"
              @sort="handleSort(column)"
            >
              {{ column.label }}
            </TableHead>
          </TableRow>
        </TableHeader>

        <TableBody>
          <!-- Data Rows -->
          <TableRow
            v-for="(row, index) in filteredData"
            :key="index"
            :clickable="clickable"
            :selected="selectedRows.has(row)"
            @click="handleRowClick(row)"
          >
            <!-- Selection Cell -->
            <TableCell v-if="selectable">
              <input
                type="checkbox"
                :checked="selectedRows.has(row)"
                @change="toggleRowSelection(row)"
                @click.stop
                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
              />
            </TableCell>

            <!-- Data Cells -->
            <TableCell
              v-for="column in columns"
              :key="column.key"
              :align="column.align"
            >
              <slot :name="`cell-${column.key}`" :row="row" :value="row[column.key]">
                {{ getCellValue(row, column) }}
              </slot>
            </TableCell>
          </TableRow>

          <!-- Empty State -->
          <TableRow v-if="filteredData.length === 0 && !loading">
            <TableCell :class="`text-center py-12 text-gray-500 dark:text-gray-400`" :colspan="columns.length + (selectable ? 1 : 0)">
              <div class="flex flex-col items-center space-y-2">
                <svg class="w-12 h-12 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2M4 13h2m13-8l-4 4m0 0l-4-4m4 4V3" />
                </svg>
                <p class="text-lg font-medium">{{ emptyMessage || 'Veri bulunamadı' }}</p>
                <p class="text-sm">Farklı filtreler deneyebilirsiniz</p>
              </div>
            </TableCell>
          </TableRow>
        </TableBody>
      </Table>
    </div>

    <!-- Pagination -->
    <div v-if="pagination && pagination.last_page > 1" class="flex items-center justify-between">
      <div class="text-sm text-gray-700 dark:text-gray-300">
        <span class="font-medium">{{ pagination.from }}</span>
        -
        <span class="font-medium">{{ pagination.to }}</span>
        /
        <span class="font-medium">{{ pagination.total }}</span>
        sonuç gösteriliyor
      </div>

      <div class="flex items-center space-x-2">
        <!-- Previous Button -->
        <button
          :disabled="pagination.current_page === 1"
          @click="goToPage(pagination.current_page - 1)"
          class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-gray-700 disabled:opacity-50 disabled:cursor-not-allowed dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200"
        >
          Önceki
        </button>

        <!-- Page Numbers -->
        <div class="flex items-center space-x-1">
          <button
            v-for="page in Math.min(pagination.last_page, 5)"
            :key="page"
            @click="goToPage(page)"
            :class="[
              'px-3 py-2 text-sm font-medium rounded-lg transition-colors',
              page === pagination.current_page
                ? 'text-blue-600 bg-blue-50 border border-blue-300 dark:bg-blue-950 dark:text-blue-400 dark:border-blue-800'
                : 'text-gray-500 bg-white border border-gray-300 hover:bg-gray-50 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200'
            ]"
          >
            {{ page }}
          </button>
        </div>

        <!-- Next Button -->
        <button
          :disabled="pagination.current_page === pagination.last_page"
          @click="goToPage(pagination.current_page + 1)"
          class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-gray-700 disabled:opacity-50 disabled:cursor-not-allowed dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200"
        >
          Sonraki
        </button>
      </div>
    </div>

    <!-- Selection Info -->
    <div v-if="selectable && selectedRows.size > 0" class="flex items-center justify-between p-4 bg-blue-50 dark:bg-blue-950/20 border border-blue-200 dark:border-blue-800 rounded-lg">
      <span class="text-sm font-medium text-blue-900 dark:text-blue-100">
        {{ selectedRows.size }} öğe seçildi
      </span>
      <button
        @click="selectedRows.clear()"
        class="text-sm font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300"
      >
        Seçimi Temizle
      </button>
    </div>
  </div>
</template>

<style scoped>
@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}

.animate-spin {
  animation: spin 1s linear infinite;
}

/* Backdrop blur support */
.backdrop-blur-sm {
  backdrop-filter: blur(4px);
}
</style>
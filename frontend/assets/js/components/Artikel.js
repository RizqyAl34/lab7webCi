const Artikel = {
    template: `
        <div>
            <h2>Manajemen Data Artikel</h2>
            <button id="btn-tambah" @click="tambah">Tambah Data</button>

            <div class="modal" v-if="showForm">
                <div class="modal-content">
                    <span class="close" @click="showForm = false">&times;</span>
                    <form id="form-data" @submit.prevent="saveData">
                        <h3>{{ formTitle }}</h3>
                        <div>
                            <input type="text" v-model="formData.judul"
                                   placeholder="Judul Artikel" required>
                        </div>
                        <div>
                            <textarea v-model="formData.isi" rows="6"
                                      placeholder="Isi Artikel" required></textarea>
                        </div>
                        <div>
                            <select v-model="formData.status">
                                <option v-for="option in statusOptions"
                                        :value="option.value">
                                    {{ option.text }}
                                </option>
                            </select>
                        </div>
                        <input type="hidden" v-model="formData.id">
                        <button type="submit" id="btnSimpan">Simpan</button>
                        <button type="button" @click="showForm = false">Batal</button>
                    </form>
                </div>
            </div>

            <!-- Info debug -->
            <p v-if="loading" style="color:#3152d6;">Memuat data...</p>
            <p v-if="errorMsg" style="color:red;">{{ errorMsg }}</p>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Judul</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="artikel.length === 0">
                        <td colspan="4" class="center-text">Tidak ada data.</td>
                    </tr>
                    <tr v-for="(row, index) in artikel" :key="row.id">
                        <td class="center-text">{{ row.id }}</td>
                        <td>{{ row.judul }}</td>
                        <td>{{ statusText(row.status) }}</td>
                        <td class="center-text">
                            <a href="#" @click.prevent="edit(row)">Edit</a>
                            <a href="#" @click.prevent="hapus(index, row.id)">Hapus</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    `,

    data() {
        return {
            artikel: [],
            loading: false,
            errorMsg: '',
            formData: { id: null, judul: '', isi: '', status: 0 },
            showForm: false,
            formTitle: 'Tambah Data',
            statusOptions: [
                { text: 'Draft',   value: 0 },
                { text: 'Publish', value: 1 },
            ]
        }
    },

    mounted() {
        this.loadData();
    },

    methods: {
        loadData() {
            this.loading  = true;
            this.errorMsg = '';

            const url = (typeof apiUrl !== 'undefined')
                ? apiUrl
                : 'http://localhost:8080';

            axios.get(url + '/post')
                .then(response => {
                    this.artikel = response.data.artikel || [];
                    this.loading = false;
                })
                .catch(error => {
                    this.errorMsg = 'Gagal memuat data: ' + error.message;
                    this.loading  = false;
                    console.log('loadData error:', error);
                });
        },

        tambah() {
            this.showForm  = true;
            this.formTitle = 'Tambah Data';
            this.formData  = { id: null, judul: '', isi: '', status: 0 };
        },

        edit(data) {
            this.showForm  = true;
            this.formTitle = 'Ubah Data';
            this.formData  = {
                id:     data.id,
                judul:  data.judul,
                isi:    data.isi,
                status: data.status
            };
        },

        hapus(index, id) {
            if (confirm('Yakin menghapus data?')) {
                axios.delete(apiUrl + '/post/' + id)
                    .then(() => {
                        this.artikel.splice(index, 1);
                    })
                    .catch(error => console.log('hapus error:', error));
            }
        },

        saveData() {
            const url = (typeof apiUrl !== 'undefined')
                ? apiUrl
                : 'http://localhost:8080';

            if (this.formData.id) {
                axios.put(url + '/post/' + this.formData.id, this.formData, {
                    headers: { 'Content-Type': 'application/json' }
                })
                .then(() => { this.loadData(); })
                .catch(error => console.log('update error:', error));
            } else {
                const payload = new URLSearchParams();
                payload.append('judul',  this.formData.judul);
                payload.append('isi',    this.formData.isi);
                payload.append('status', this.formData.status);

                axios.post(url + '/post', payload)
                    .then(() => { this.loadData(); })
                    .catch(error => console.log('tambah error:', error));
            }

            this.formData = { id: null, judul: '', isi: '', status: 0 };
            this.showForm = false;
        },

        statusText(status) {
            if (!status) return 'Draft';
            return status == 1 ? 'Publish' : 'Draft';
        }
    }
};
const datatableCall = (targetId, url, columns) => {
    $(`#${targetId}`).DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: url,
            type: "GET",
            data: function (d) {
                d.mode = "datatable";
                d.bulan = $("#bulan_filter").val() ?? null;
                d.tahun = $("#tahun_filter").val() ?? null;
                d.tanggal = $("#tanggal_filter").val() ?? null;
            },
        },
        columns: columns,
        lengthMenu: [
            [25, 50, 100, 250, -1],
            [25, 50, 100, 250, "All"],
        ],
    });
};

const ajaxCall = (url, method, data, successCallback, errorCallback) => {
    $.ajax({
        type: method,
        enctype: "multipart/form-data",
        url,
        cache: false,
        data,
        contentType: false,
        processData: false,
        headers: {
            Accept: "application/json",
            "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content"),
        },
        dataType: "json",
        success: function (response) {
            successCallback(response);
        },
        error: function (error) {
            errorCallback(error);
        },
    });
};

const setButtonLoadingState = (buttonSelector, isLoading, title = "Simpan") => {
    const buttonText = isLoading
        ? `<div class="spinner-border spinner-border-sm me-2" role="status">
            </div>
         ${title}`
        : title;
    $(buttonSelector).prop("disabled", isLoading).html(buttonText);
};

const notification = (type, message) => {
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener("mouseenter", Swal.stopTimer);
            toast.addEventListener("mouseleave", Swal.resumeTimer);
        },
    });

    Toast.fire({
        icon: type,
        title: type === "success" ? "Success" : "Error",
        text: message,
    });
};

const getModal = (targetId, url = null, fields = null) => {
    $(`#${targetId}`).modal("show");
    $(`#${targetId} .form-control`).removeClass("is-invalid");
    $(`#${targetId} .invalid-feedback`).html("");

    const cekLabelModal = $("#label-modal");
    if (cekLabelModal) {
        $("#id").val("");
        cekLabelModal.text("Tambah");
    }

    if (url) {
        cekLabelModal.text("Edit");

        const successCallback = function (response) {
            fields.forEach((field) => {
                if (response.data[field]) {
                    $(`#${targetId} #${field}`).val(response.data[field]);
                }
            });
        };

        const errorCallback = function (error) {
            console.log(error);
        };

        ajaxCall(url, "GET", null, successCallback, errorCallback);
    }
    $(`#${targetId} .form-control`).val("");
};

const handleValidationErrors = (error, formId = null, fields = null) => {
    if (error.responseJSON.data && fields) {
        fields.forEach((field) => {
            if (error.responseJSON.data[field]) {
                $(`#${formId} #${field}`).addClass("is-invalid");
                $(`#${formId} #error${field}`).html(
                    error.responseJSON.data[field][0]
                );
            } else {
                $(`#${formId} #${field}`).removeClass("is-invalid");
                $(`#${formId} #error${field}`).html("");
            }
        });
    } else {
        notification("error", error.responseJSON.message);
    }
};

const handleSuccess = (
    response,
    dataTableId = null,
    modalId = null,
    redirect = null
) => {
    if (dataTableId !== null) {
        notification("success", response.message);
        $(`#${dataTableId}`).DataTable().ajax.reload();
    }

    if (modalId !== null) {
        $(`#${modalId}`).modal("hide");
    }

    if (redirect !== null) {
        if (redirect === "no") {
            notification("success", response.message ?? response);
        } else {
            notification("success", response.message ?? response);
            setTimeout(() => {
                window.location.href = redirect;
            }, 1500);
        }
    }
};

const confirmDelete = (url, tableId) => {
    Swal.fire({
        title: "Apakah Kamu Yakin?",
        text: "Ingin menghapus data ini!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, hapus!",
    }).then((result) => {
        if (result.isConfirmed) {
            const data = null;

            const successCallback = function (response) {
                handleSuccess(response, tableId, null);
            };

            const errorCallback = function (error) {
                console.log(error);
            };

            ajaxCall(url, "DELETE", data, successCallback, errorCallback);
        }
    });
};

const select2ToJson = (selector, url) => {
    const selectElem = $(selector);

    if (selectElem.children().length > 0) {
        return;
    }

    const successCallback = function (response) {
        selectElem.append(
            $("<option>", { value: "", text: "-- Pilih Data --" })
        );

        response.data.forEach(function (row) {
            const option = $("<option>", { value: row.id, text: row.nama });
            selectElem.append(option);
        });

        selectElem.select2({
            theme: "bootstrap-5",
            width: "100%",
            dropdownParent: $("#createModal"),
        });
    };

    const errorCallback = function (error) {
        console.error(error);
    };

    ajaxCall(url, "GET", null, successCallback, errorCallback);
};

const confirmStok = (id) => {
    Swal.fire({
        title: "Apakah Kamu Yakin?",
        text: "Akan menyelesaikan proses!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Konfirmasi!",
    }).then((willDelete) => {
        if (willDelete) {
            const data = new FormData();
            data.append("_method", "PUT");
            data.append("status", "1");

            const successCallback = function (response) {
                handleSuccess(response, null, null, `/admin/stok/${id}`);
            };

            const errorCallback = function (error) {
                console.log(error);
            };

            ajaxCall(
                `/admin/stok/${id}`,
                "POST",
                data,
                successCallback,
                errorCallback
            );
        }
    });
};

const getMenus = (page, mode = null) => {
    let search = $("#search").val();
    let kategori = $("#kategori").val();
    $.ajax({
        url: mode ? `/?page=${page}` : "/kasir/menu?page=" + page,
        data: {
            search,
            kategori,
        },
    }).done(function (data) {
        $("#menus").html(data);
    });
};

const formatRupiah = (angka) => {
    var reverse = angka.toString().split("").reverse().join(""),
        ribuan = reverse.match(/\d{1,3}/g);
    ribuan = ribuan.join(".").split("").reverse().join("");
    return "Rp " + ribuan;
};

const grandTotal = () => {
    let totalFiks = 0;
    $(".totalFiks").each(function () {
        totalFiks += parseInt($(this).val());
    });
    $("#grandTotal").val(totalFiks);
    $("#textGrandTotal").text(formatRupiah(totalFiks));

    if (totalFiks > 0) {
        $(`#proses`).removeClass("d-none");
        $(`#meja-input`).removeClass("d-none");
    } else {
        $(`#proses`).addClass("d-none");
        $(`#meja-input`).addClass("d-none");
    }
};

const getChart = (kode, free = null) => {
    const successCallback = function (response) {
        let menu = response.data;
        let menuId = menu.id;

        if ($("#menu_" + menuId).length === 0) {
            let tableRows = `
                <tr id="menu_${menuId}">
                    <td><button class="border-0 bg-white text-danger" onclick="removeMenu('menu_${menuId}')">x</button> ${
                menu.nama
            }</td>
                    <td>
                        <input class="form-control" name="qty[]" min="1" value="1" oninput="changeTotal(${menuId})" type="number" id="qty_${menuId}"/>
                    </td>
                    <td>
                        <input type="hidden" value="${
                            menu.harga_jual
                        }" id="harga_${menuId}"/>
                        <span id="total_${menuId}">${formatRupiah(
                menu.harga_jual
            )}</span>
                        <input type="hidden" name="total[]" class="totalFiks" value="${
                            menu.harga_jual
                        }" id="totalFiks_${menuId}"/>
                        <input type="hidden" name="menu_id[]" value="${menuId}" id="menu_${menuId}"/>
                    </td>
                </tr>
            `;
            $("#list-transaksi tbody").append(tableRows);

            grandTotal();
        }
    };

    const errorCallback = function (error) {
        console.log(error);
    };

    ajaxCall(
        free ? `/menu/${kode}` : `/kasir/menu/${kode}`,
        "GET",
        null,
        successCallback,
        errorCallback
    );
};

const changeTotal = (menuId) => {
    let qty = $("#qty_" + menuId).val();
    let harga = $("#harga_" + menuId).val();
    let total = qty * harga;
    $("#total_" + menuId).text(formatRupiah(total));
    $("#totalFiks_" + menuId).val(total);
    hitungKembalian();

    grandTotal();
};

const removeMenu = (menu) => {
    $(`#${menu}`).remove();
    grandTotal();
};

const hitungKembalian = () => {
    const bayar = $("#bayar").val();
    const grandTotal = $("#grandTotal").val();
    const kembalian = bayar
        ? bayar >= grandTotal
            ? bayar - grandTotal
            : 0
        : 0;
    $("#textKembalian").html(formatRupiah(kembalian));
};

const resetChart = () => {
    const chartElement = document.querySelector("#chart-transaksi");
    if (chartElement) {
        chartElement.innerHTML = "";
    }
};

const renderChart = (labels, transaksi) => {
    resetChart();

    const options = {
        chart: {
            type: "line",
            height: 350,
        },
        series: [
            {
                name: "Transaksi",
                data: transaksi,
            },
        ],
        xaxis: {
            categories: labels,
        },
        title: {
            text: "Grafik Transaksi Bulan Ini",
        },
    };

    const chart = new ApexCharts(
        document.querySelector("#chart-transaksi"),
        options
    );
    chart.render();
};

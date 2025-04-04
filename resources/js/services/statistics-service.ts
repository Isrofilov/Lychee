import axios, { type AxiosResponse } from "axios";
import Constants from "./constants";

const StatisticsService = {
	getUserSpace(): Promise<AxiosResponse<App.Http.Resources.Statistics.UserSpace[]>> {
		return axios.get(`${Constants.getApiUrl()}Statistics::userSpace`, { data: {} });
	},
	getSizeVariantSpace(albumId: string | null = null): Promise<AxiosResponse<App.Http.Resources.Statistics.Sizes[]>> {
		return axios.get(`${Constants.getApiUrl()}Statistics::sizeVariantSpace`, { params: { album_id: albumId }, data: {} });
	},
	getAlbumSpace(albumId: string | null = null): Promise<AxiosResponse<App.Http.Resources.Statistics.Album[]>> {
		return axios.get(`${Constants.getApiUrl()}Statistics::albumSpace`, { params: { album_id: albumId }, data: {} });
	},
	getTotalAlbumSpace(albumId: string | null = null): Promise<AxiosResponse<App.Http.Resources.Statistics.Album[]>> {
		return axios.get(`${Constants.getApiUrl()}Statistics::totalAlbumSpace`, { params: { album_id: albumId }, data: {} });
	},
	getCountsOverTime(min: number, max: number, type: "taken_at" | "created_at"): Promise<AxiosResponse<App.Http.Resources.Statistics.CountsData>> {
		return axios.get(`${Constants.getApiUrl()}Statistics::getCountsOverTime`, { params: { min, max, type }, data: {} });
	},
};

export default StatisticsService;
